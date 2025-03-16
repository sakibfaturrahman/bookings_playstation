@extends('admin.layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Home</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        <li>
            <i class='bx bxs-calendar-check'></i>
            <span class="text">
                <h3>{{ $bookingTotal }}</h3>
                <p>Total Booking Masuk</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>{{ $customerTotal }}</h3>
                <p>Customer</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-dollar-circle'></i>
            <span class="text">
                <h3>{{ number_format($bookingTotalPrice, 0, ',', '.') }}</h3>
                <p>Total Pendapatan</p>
            </span>
        </li>
    </ul>


    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Recent Bookings</h3>
                <i class='bx bx-search'></i>
                <i class='bx bx-filter'></i>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>PS</th>
                        <th>Customer</th>
                        <th>Tanggal Booking</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $item->playstation->name }}
                            </td>
                            <td>
                                {{ $item->user->name }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->booking_date)->locale('id')->translatedFormat('l, d F Y') }}
                            </td>
                            <td>
                                {{ number_format($item->total_price, 0, ',', '.') }}
                            </td>
                            <td>
                                @if ($item->status == 'Pending')
                                    <span class="badge text-bg-warning">{{ $item->status }}</span>
                                @elseif ($item->status == 'Paid')
                                    <span class="badge text-bg-success">{{ $item->status }}</span>
                                @elseif ($item->status == 'Cancelled')
                                    <span class="badge text-bg-danger">{{ $item->status }}</span>
                                @endif
                            </td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
