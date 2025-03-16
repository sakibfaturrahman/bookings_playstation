@extends('admin.layouts.app')
@section('title')
    Data Bookings
@endsection

@section('content')
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Recent Orders</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>PS</th>
                        <th>Customer</th>
                        <th>Tanggal Booking Dibuat</th>
                        <th>Tanggal Booking</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->playstation->name }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, d F Y') }}
                            </td>

                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->booking_date)->locale('id')->translatedFormat('l, d F Y') }}
                            </td>
                            <td>{{ number_format($item->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->status == 'Pending')
                                    <span class="badge text-bg-warning">{{ $item->status }}</span>
                                @elseif ($item->status == 'Paid')
                                    <span class="badge text-bg-success">{{ $item->status }}</span>
                                @elseif ($item->status == 'Cancelled')
                                    <span class="badge text-bg-danger">{{ $item->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- <div class="pagination">
                {{ $bookings->links() }}
            </div> --}}
        </div>
    </div>






    @push('script')
        @if ($errors->any())
            <script>
                $(document).ready(function() {
                    $('#errorList').empty();
                    @foreach ($errors->all() as $error)
                        $('#errorList').append('<li>{{ $error }}</li>');
                    @endforeach
                    $('#errorModal').modal('show');
                });
            </script>
        @endif
    @endpush
@endsection
