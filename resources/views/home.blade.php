<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Bookings ID') }}
        </h2>
        <span class="mt-4">Booking PS idamanmu dan mainkan!</span>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-semibold">Pilih Tanggal Booking</h2>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Pilih PlayStation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="selected-date-text"></p>
                    <form id="bookingForm">
                        <input type="hidden" id="selected_date" name="booking_date">
                        <div class="mb-3">
                            <label for="playstation_id" class="form-label">Pilih PlayStation</label>
                            <select name="playstation_id" id="playstation_id" class="form-select" required>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Booking Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                select: function(info) {
                    let selectedDate = info.startStr;
                    document.getElementById('selected-date-text').innerText =
                        `Booking pada ${selectedDate}`;
                    document.getElementById('selected_date').value = selectedDate;


                    axios.get('/playstations/list')
                        .then(response => {
                            console.log("Data dari server:", response.data);

                            let select = document.getElementById('playstation_id');
                            select.innerHTML = '';

                            if (!Array.isArray(response.data)) {
                                console.error("Data tidak dalam format array:", response.data);
                                return;
                            }

                            response.data.forEach(ps => {
                                console.log(
                                    `Menambahkan: ${ps.name} - Rp ${ps.harga_sewa}`);
                                let option = new Option(`${ps.name} - Rp ${ps.harga_sewa}`,
                                    ps.id);
                                select.add(option);
                            });

                            new bootstrap.Modal(document.getElementById('bookingModal')).show();
                        })
                        .catch(error => {
                            console.error("Error Axios:", error);
                            alert("Gagal memuat daftar PlayStation.");
                        });
                },
                events: '/bookings/events'
            });
            calendar.render();

            document.getElementById('bookingForm').addEventListener('submit', function(event) {
                event.preventDefault();
                let formData = new FormData(this);

                console.log("Data yang dikirim:", Object.fromEntries(formData));

                axios.post('/bookings', Object.fromEntries(formData))
                    .then(response => {
                        alert("Booking berhasil!");
                        window.location.href = 'payment/';
                    })
                    .catch(error => {
                        console.error("Error saat booking:", error.response.data);
                        alert("Gagal booking: " + error.response.data.message);
                    });
            });
        });
    </script>
</x-app-layout>
