<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\PowerPlant;
use App\Models\Certificate;
use App\Models\Order;
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
                       ->with('certificates.energyReport.powerPlant') // Eager load untuk detail
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('buyer.orders-index', compact('orders'));
    }

    /**
     * Memproses pesanan dari halaman detail produk.
     */
    public function processOrder(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'quantity' => 'required|numeric|min:1',
            'min_purchase' => 'required|numeric|min:0',
        ]);

        $quantityNeeded = floatval($validated['quantity']);
        $minPurchase = floatval($validated['min_purchase']);
        $powerPlant = PowerPlant::findOrFail($validated['power_plant_id']);
        $pricePerMwh = 35000;

        if ($quantityNeeded < $minPurchase) {
            return redirect()->back()->with('error', 'Jumlah pembelian tidak memenuhi syarat minimal ' . $minPurchase . ' MWh.');
        }

        try {
            // Memulai transaksi database untuk menjaga konsistensi data
            $order = DB::transaction(function () use ($powerPlant, $quantityNeeded, $pricePerMwh) {
                
                // KUNCI PERBAIKAN: Secara eksplisit menyebutkan nama tabel 'certificates'
                $certificatesToReserve = $powerPlant->certificates()
                                                    ->where('certificates.status', 'available_for_sale') // INI PERBAIKANNYA
                                                    ->lockForUpdate()
                                                    ->orderBy('certificates.created_at', 'asc') // Dibuat eksplisit juga
                                                    ->get();

                // Hitung total MWh yang benar-benar tersedia
                $availableMwh = $certificatesToReserve->sum('amount_mwh');
                
                // Jika stok tidak cukup, batalkan transaksi
                if ($availableMwh < $quantityNeeded) {
                    throw new \Exception('Maaf, stok energi yang tersedia hanya ' . number_format($availableMwh, 2, ',', '.') . ' MWh.');
                }

                // Buat pesanan (Order) baru
                $newOrder = Order::create([
                    'order_uid' => 'REC-TRX-' . strtoupper(Str::random(10)),
                    'buyer_id' => Auth::id(),
                    'total_price' => $quantityNeeded * $pricePerMwh,
                    'virtual_account_number' => '8808' . str_pad(Auth::id(), 10, '0', STR_PAD_LEFT),
                    'status' => 'pending_payment',
                ]);

                // Amankan sertifikat
                $mwhReserved = 0;
                foreach ($certificatesToReserve as $certificate) {
                    if ($mwhReserved >= $quantityNeeded) {
                        break;
                    }
                    $certificate->status = 'on_hold';
                    $certificate->order_id = $newOrder->id;
                    $certificate->save();
                    $mwhReserved += $certificate->amount_mwh;
                }
                
                return $newOrder;
            });

        } catch (\Exception $e) {
            // Kembali dengan pesan error jika transaksi gagal
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Arahkan ke halaman pembayaran jika berhasil
        return redirect()->route('buyer.orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
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
