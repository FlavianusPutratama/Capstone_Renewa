<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\PowerPlant;
use App\Models\Certificate;
use App\Models\Order;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())
                        ->with('certificates', 'buyer.company') 
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('buyer.orders-index', compact('orders'));
    }

    public function processOrder(Request $request)
    {
        $validated = $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'quantity' => 'required|numeric|min:1',
            'min_purchase' => 'required|numeric|min:0',
            'category' => 'required|string|in:Retail,Signature,Enterprise'
        ]);

        $category = $request->session()->get('checkout_category', 'Personal');

        
        if ($validated['category'] === 'Enterprise' && !Auth::user()->company) {
            session(['pending_order_data' => $validated]);
            return redirect()->route('buyer.checkout.company.create');
        }

        $orderUid = 'REC-TRX-' . strtoupper(Str::random(10));
        $totalPrice = $validated['quantity'] * 35000; // atau sesuai logika harga Anda
        $virtualAccountNumber = '8808' . str_pad(auth()->id(), 10, '0', STR_PAD_LEFT);

        try {
            $order = $this->_createOrderFromData($validated);
            return redirect()->route('buyer.orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function createCompanyForm()
    {
        if (!session()->has('pending_order_data')) {
            return redirect()->route('buyer.marketplace')->with('error', 'Tidak ada proses pembelian yang aktif.');
        }
        return view('buyer.company-details');
    }

    public function storeCompanyForm(Request $request)
    {
        $validatedCompany = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'nib' => 'required|string|max:255',
        ]);

        Company::create([
            'user_id' => Auth::id(),
            'name' => $validatedCompany['name'],
            'address' => $validatedCompany['address'],
            'phone_number' => $validatedCompany['phone_number'],
            'nib' => $validatedCompany['nib'],
        ]);

        $pendingOrderData = session()->pull('pending_order_data');
        if (!$pendingOrderData) {
            return redirect()->route('buyer.marketplace')->with('error', 'Sesi pesanan Anda telah berakhir.');
        }

        try {
            $order = $this->_createOrderFromData($pendingOrderData);
            return redirect()->route('buyer.orders.show', $order->id)->with('success', 'Data perusahaan berhasil disimpan! Silakan lanjutkan pembayaran.');
        } catch (\Exception $e) {
            return redirect()->route('buyer.marketplace')->with('error', $e->getMessage());
        }
    }

    private function _createOrderFromData(array $data)
    {
        $quantityNeeded = floatval($data['quantity']);
        $minPurchase = floatval($data['min_purchase']);
        $powerPlant = PowerPlant::findOrFail($data['power_plant_id']);
        $pricePerMwh = 35000;

        if ($quantityNeeded < $minPurchase) {
            throw new \Exception('Jumlah pembelian tidak memenuhi syarat minimal ' . $minPurchase . ' MWh.');
        }

        return DB::transaction(function () use ($powerPlant, $quantityNeeded, $pricePerMwh, $data) {
            $certificatesToReserve = $powerPlant->certificates()
                                                ->where('certificates.status', 'available_for_sale')
                                                ->lockForUpdate()
                                                ->orderBy('certificates.created_at', 'asc')
                                                ->get();

            $availableMwh = $certificatesToReserve->sum('amount_mwh');
            
            if ($availableMwh < $quantityNeeded) {
                throw new \Exception('Maaf, stok energi yang tersedia hanya ' . number_format($availableMwh, 2, ',', '.') . ' MWh.');
            }

            $newOrder = Order::create([
                'order_uid' => 'REC-TRX-' . strtoupper(Str::random(10)),
                'buyer_id' => Auth::id(),
                'total_price' => $quantityNeeded * $pricePerMwh,
                'virtual_account_number' => '8808' . str_pad(Auth::id(), 10, '0', STR_PAD_LEFT),
                'status' => 'pending_payment',
                'category' => $data['category']
            ]);

            $mwhToFulfill = $quantityNeeded;

            foreach ($certificatesToReserve as $certificate) {
                if ($mwhToFulfill <= 0) {
                    break;
                }

                if ($certificate->amount_mwh > $mwhToFulfill) {
                    $originalAmount = $certificate->amount_mwh;
                    $certificate->amount_mwh = $originalAmount - $mwhToFulfill;
                    $certificate->save();

                    $newCertForOrder = $certificate->replicate();
                    $newCertForOrder->amount_mwh = $mwhToFulfill;
                    $newCertForOrder->status = 'on_hold';
                    $newCertForOrder->order_id = $newOrder->id;
                    $newCertForOrder->certificate_uid = 'REC-' . date('Y') . '-' . strtoupper(Str::random(8));
                    $newCertForOrder->save();
                    $mwhToFulfill = 0;

                } else {
                    $mwhToFulfill -= $certificate->amount_mwh;
                    $certificate->status = 'on_hold';
                    $certificate->order_id = $newOrder->id;
                    $certificate->save();
                }
            }
            
            return $newOrder;
        });
    }

    public function showOrder(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }

        // Hitung total MWh dari sertifikat yang terkait dengan pesanan ini
        $totalMwh = $order->certificates()->sum('amount_mwh');

        return view('buyer.order-show', compact('order', 'totalMwh'));
    }

    public function confirmPayment(Request $request, Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }

        if ($order->status === 'pending_payment') {
            $order->status = 'awaiting_confirmation';
            $order->payment_confirmed_at = now();
            $order->save();
            return redirect()->route('buyer.orders.show', $order->id)->with('success', 'Konfirmasi pembayaran Anda telah diterima dan akan segera diverifikasi oleh Issuer.');
        }

        return redirect()->route('buyer.orders.show', $order->id)->with('info', 'Pesanan ini sudah dikonfirmasi sebelumnya.');
    }

    /**
     * Menampilkan halaman detail sertifikat untuk pesanan yang sudah selesai.
     */
    public function showCertificate(Order $order)
    {
        // 1. Otorisasi: Pastikan order ini milik user yang sedang login.
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // 2. Validasi Status: Pastikan hanya order yang sudah selesai yang bisa dilihat sertifikatnya.
        if ($order->status !== 'completed') {
            return redirect()->route('buyer.orders.show', $order->id)->with('error', 'Sertifikat hanya dapat dilihat untuk pesanan yang telah selesai.');
        }

        // 3. Eager Load relasi yang dibutuhkan untuk tampilan sertifikat.
        $order->load(['buyer.company', 'certificates.energyReport.powerPlant']);

        // 4. Hitung total MWh, sama seperti di controller tracking publik.
        $totalMwh = $order->certificates->sum('amount_mwh');

        // 5. Tampilkan view sertifikat dengan data yang sudah disiapkan.
        return view('buyer.certificate-detail', compact('order', 'totalMwh'));
    }
}