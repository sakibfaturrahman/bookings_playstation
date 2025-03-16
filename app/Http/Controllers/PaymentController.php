<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Booking $booking)
  
    {
        $bookings = Booking::where('user_id', auth()->id())->get();
        return view('booking_recent', compact('booking','bookings'));
    }

    public function callback(Request $request)
{
    // Ambil Server Key dari .env
    $serverKey = config('midtrans.server_key');

    // Validasi jika tidak ada booking_id
    if (!$request->has('booking_id')) {
        return response()->json(['message' => 'Booking ID tidak ditemukan'], 400);
    }

    // Buat hash untuk validasi request dari Midtrans
    $expectedSignature = hash("sha512", 
        $request->booking_id . 
        $request->status_code . 
        $request->gross_amount . 
        $serverKey
    );

    // Validasi Signature Key
    if ($expectedSignature !== $request->signature_key) {
        return response()->json(['message' => 'Invalid signature key'], 403);
    }

    // Cari booking berdasarkan ID
    $booking = Booking::where('id', $request->booking_id)->first();

    // Jika booking tidak ditemukan, kirim respons error
    if (!$booking) {
        return response()->json(['message' => 'Booking tidak ditemukan'], 404);
    }

    // Update status pembayaran sesuai dengan response Midtrans
    if (in_array($request->transaction_status, ['capture', 'settlement'])) {
        $booking->update(['status' => 'paid']);
    } elseif (in_array($request->transaction_status, ['cancel', 'expire', 'failure'])) {
        $booking->update(['status' => 'canceled']);
    }

    return response()->json(['message' => 'Payment status updated successfully']);
}

public function updateStatus($id, Request $request)
{
    $booking = Booking::findOrFail($id);

    if ($request->status == 'Paid') {
        $booking->update(['status' => 'Paid']);
        return response()->json(['success' => true, 'message' => 'Status updated to Paid']);
    } elseif ($request->status == 'Canceled') {
        $booking->update(['status' => 'Canceled']);
        return response()->json(['success' => true, 'message' => 'Status updated to Canceled']);
    }

    return response()->json(['success' => false, 'message' => 'Invalid status'], 400);
}

}