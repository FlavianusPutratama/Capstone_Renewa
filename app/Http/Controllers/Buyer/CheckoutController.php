<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\PowerPlant;
use App\Models\Certificate;
use App\Models\Order;
use App\Models\Company; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

    /**
     * Menampilkan riwayat pesanan milik buyer.
     */
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())
                        ->with('certificates.energyReport.powerPlant')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('buyer.orders-index', compact('orders'));
    }

    /**
     * Memproses pesanan dari halaman detail produk.
     */
    public function processOrder(Request $request)
    {
        // 1. Validasi (menambahkan 'category')
        $validated = $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'quantity' => 'required|numeric|min:1',
            'min_purchase' => 'required|numeric|min:0',
            'category' => 'required|string|in:Retail,Signature,Enterprise' // Tambahkan validasi untuk kategori
        ]);
        
        // 2. Cek Logika Enterprise
        // Jika kategori adalah Enterprise dan user belum punya data perusahaan,
        // simpan data pesanan sementara di session dan arahkan ke form perusahaan.
        if ($validated['category'] === 'Enterprise' && !Auth::user()->company) {
            session(['pending_order_data' => $validated]);
            return redirect()->route('buyer.checkout.company.create');
        }

        // 3. Proses pembuatan pesanan jika bukan enterprise atau data perusahaan sudah ada
        try {
            $order = $this->_createOrderFromData($validated);
            return redirect()->route('buyer.orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk mengisi data perusahaan.
     */
    public function createCompanyForm()
    {
        // Cek apakah ada data pesanan yang tertunda di session
        if (!session()->has('pending_order_data')) {
            return redirect()->route('buyer.marketplace')->with('error', 'Tidak ada proses pembelian yang aktif.');
        }
        return view('buyer.company-details');
    }

    /**
     * Menyimpan data perusahaan dan melanjutkan proses pesanan.
     */
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

        // Ambil data pesanan dari session
        $pendingOrderData = session()->pull('pending_order_data');
        if (!$pendingOrderData) {
            return redirect()->route('buyer.marketplace')->with('error', 'Sesi pesanan Anda telah berakhir.');
        }

        // Lanjutkan membuat pesanan
        try {
            $order = $this->_createOrderFromData($pendingOrderData);
            return redirect()->route('buyer.orders.show', $order->id)->with('success', 'Data perusahaan berhasil disimpan! Silakan lanjutkan pembayaran.');
        } catch (\Exception $e) {
            return redirect()->route('buyer.marketplace')->with('error', $e->getMessage());
        }
    }


    /**
     * Logika inti untuk membuat pesanan, diekstrak agar bisa dipakai ulang.
     */
    private function _createOrderFromData(array $data)
    {
        $quantityNeeded = floatval($data['quantity']);
        $minPurchase = floatval($data['min_purchase']);
        $powerPlant = PowerPlant::findOrFail($data['power_plant_id']);
        $pricePerMwh = 35000;

        if ($quantityNeeded < $minPurchase) {
            throw new \Exception('Jumlah pembelian tidak memenuhi syarat minimal ' . $minPurchase . ' MWh.');
        }

        return DB::transaction(function () use ($powerPlant, $quantityNeeded, $pricePerMwh) {
            $certificatesToReserve = $powerPlant->certificates()
                                                ->where('certificates.status', 'available_for_sale')
                                                ->lockForUpdate()
                                                ->orderBy('created_at', 'asc')
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
            ]);

            $mwhToFulfill = $quantityNeeded;

            foreach ($certificatesToReserve as $certificate) {
                if ($mwhToFulfill <= 0) {
                    break; // Hentikan jika pesanan sudah terpenuhi
                }

                // Cek apakah sertifikat ini lebih besar dari yang dibutuhkan
                if ($certificate->amount_mwh > $mwhToFulfill) {
                    // KASUS 1: Sertifikat perlu dipecah

                    // 1. Kurangi jumlah MWh pada sertifikat asli
                    $originalAmount = $certificate->amount_mwh;
                    $certificate->amount_mwh = $originalAmount - $mwhToFulfill;
                    $certificate->save();

                    // 2. Buat sertifikat baru sejumlah yang dibeli untuk pesanan ini
                    $newCertForOrder = $certificate->replicate(); // Salin data sertifikat
                    $newCertForOrder->amount_mwh = $mwhToFulfill;
                    $newCertForOrder->status = 'on_hold'; // Status untuk pesanan
                    $newCertForOrder->order_id = $newOrder->id;
                    $newCertForOrder->certificate_uid = 'REC-' . date('Y') . '-' . strtoupper(Str::random(8));
                    $newCertForOrder->save();

                    // 3. Pesanan sudah terpenuhi
                    $mwhToFulfill = 0;

                } else {
                    // KASUS 2: Sertifikat lebih kecil atau sama dengan yang dibutuhkan. Ambil seluruhnya.
                    
                    // 1. Kurangi jumlah MWh yang masih perlu dicari
                    $mwhToFulfill -= $certificate->amount_mwh;

                    // 2. Kaitkan seluruh sertifikat ini ke pesanan
                    $certificate->status = 'on_hold';
                    $certificate->order_id = $newOrder->id;
                    $certificate->save();
                }
            }
            
            return $newOrder;
        });
    }


    /**
     * Menampilkan halaman instruksi pembayaran.
     */
    public function showOrder(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }
        return view('buyer.order-show', compact('order'));
    }

    /**
     * Menangani konfirmasi pembayaran dari pengguna.
     */
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
}