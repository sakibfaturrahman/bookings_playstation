<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class DashboardController extends Controller
{
    public function index()
    {
      $data = [
        'bookings' => Booking::paginate(10),
        'bookingTotalPrice' => Booking::sum('total_price'),
        'bookingTotal' => Booking::count(),
        'customerTotal' => User::where('role', 'customer')->count(),
      ];
        return view('admin.dashboard.index', $data);
    }
}
