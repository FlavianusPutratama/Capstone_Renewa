<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecTrackingController extends Controller
{
    /**
     * Menangani permintaan pencarian dari form (tradisional/fallback).
     */
    public function track(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string|exists:orders,order_uid',
        ]);

        $order = Order::where('order_uid', $request->order_id)
                      ->where('category', 'Enterprise')
                      ->first();

        if (!$order) {
            return redirect()->route('welcome')->with('error', 'Order ID tidak ditemukan atau bukan merupakan pembelian kategori Enterprise.');
        }

        return redirect()->route('rec.show', ['order' => $order->order_uid]);
    }

    /**
     * ==========================================================
     * METODE BARU UNTUK MENANGANI PERMINTAAN AJAX
     * ==========================================================
     */
    public function ajaxTrack(Request $request)
    {
        // Validasi input secara manual untuk kontrol response JSON
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422); // 422 Unprocessable Entity
        }
        
        // Cari order berdasarkan order_uid dan kategori
        $order = Order::where('order_uid', $request->order_id)
                      ->where('category', 'Enterprise')
                      ->first();

        // Jika order tidak ditemukan, kirim response error
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order ID tidak ditemukan atau bukan merupakan pembelian kategori Enterprise.',
            ], 404); // 404 Not Found
        }

        // Jika berhasil, kirim response sukses dengan URL redirect
        return response()->json([
            'success' => true,
            'redirect_url' => route('rec.show', ['order' => $order->order_uid]),
        ]);
    }


    /**
     * Menampilkan detail REC dari order yang valid.
     */
    public function show(Order $order)
    {
        if ($order->category !== 'Enterprise') {
            abort(404, 'Order tidak ditemukan.');
        }
        
        $order->load(['buyer.company', 'certificates.energyReport.powerPlant']);
        $totalMwh = $order->certificates->sum('amount_mwh');

        return view('rec-detail', compact('order', 'totalMwh'));
    }
}