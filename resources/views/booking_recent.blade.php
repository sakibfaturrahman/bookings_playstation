<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Bookings ID') }}
        </h2>
        <span class="mt-4">Selesaikan pembayaran dan ambil ps mu!</span>
    </x-slot>

    {{-- create tabel --}}

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-semibold">Bookings</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Playstation</th>
                                <th scope="col">Tanggal Booking</th>
                                <th scope="col"> Total Harga</th>
                                <th scope="col">Status</th>
                                <th scope="col">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                @if ($booking->status != 'Cancelled')
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $booking->playstation->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d F Y') }}
                                        </td>
                                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($booking->status == 'Pending')
                                                <span class="badge text-bg-warning">{{ $booking->status }}</span>
                                            @elseif ($booking->status == 'Paid')
                                                <span class="badge text-bg-success">{{ $booking->status }}</span>
                                            @elseif ($booking->status == 'Cancelled')
                                                <span class="badge text-bg-danger">{{ $booking->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($booking->status == 'Pending')
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    id="pay-button">Bayar</button>
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data <a
                                                href="{{ route('index') }}">Mulai Booking.</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $booking->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    alert("Pembayaran berhasil! Status booking anda akan diperbarui.");
                    console.log("Mengirim request ke server...");

                    fetch("{{ route('payment.updateStatus', ['id' => $booking->id ?? 0]) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                status: "Paid"
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Response dari server:", data);
                            if (data.success) {
                                window.location.href =
                                    "{{ route('booking.confirm', ['id' => $booking->id ?? 0]) }}";
                            } else {
                                alert("Gagal memperbarui status: " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error updating status:", error);
                        });


                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>

</x-app-layout>
