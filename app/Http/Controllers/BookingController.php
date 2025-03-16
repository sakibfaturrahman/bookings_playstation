<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;
use App\Models\Playstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('admin.booking.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'playstation_id' => 'required|exists:playstation,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ],[
            'booking_date.after_or_equal' => 'Tanggal booking harus atau lebih dari hari ini'
        ]);
    
        
        $playstation = Playstation::findOrFail($request->playstation_id);
        $weekend = in_array(date('N', strtotime($request->booking_date)), [6, 7]);
        $biayaWeekend = $weekend ? 50000 : 0;
        $totalPrice = $playstation->harga_sewa + $biayaWeekend;
    
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'playstation_id' => $request->playstation_id,
            'booking_date' => $request->booking_date,
            'total_price' => $totalPrice,
            'status' => 'Pending',
        ]);
    

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; 
        Config::$isSanitized = true;
        Config::$is3ds = true;
    
        $transaction = [
            'transaction_details' => [
                'order_id' => $booking->id,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];
    
        try {
            $snapToken = Snap::getSnapToken($transaction);
            $booking->update(['snap_token' => $snapToken]); 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mendapatkan Snap Token'], 500);
        }
    
        return response()->json([
            'message' => 'Booking berhasil!',
            'redirect_url' => route('payment.index', ['booking' => $booking->id])
        ], 201);
    }

    public function getEvents()
    {
        $bookings = Booking::select('booking_date')
            ->where('status', '!=', 'canceled')
            ->get();
    
        $events = $bookings->map(function ($booking) {
            return [
                'title' => 'Telah Dibooking',
                'start' => $booking->booking_date,
                'backgroundColor' => 'red',
                'borderColor' => 'red'
            ];
        });
    
        return response()->json($events);
    }

    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
    
        if ($booking->status !== 'Paid') {
            return redirect()->route('payment.index')->with('error', 'Pembayaran belum dikonfirmasi.');
        }
    
        return view('confirm', compact('booking'));
    }
    
   
}
