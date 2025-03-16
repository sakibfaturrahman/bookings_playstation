<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .receipt {
            max-width: 380px;
            background: white;
            padding: 20px;
            border: 2px dashed black;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            font-family: 'Courier New', Courier, monospace;
        }

        .receipt h2 {
            font-size: 18px;
            border-bottom: 1px dashed black;
            padding-bottom: 5px;
            text-align: center;
        }

        .receipt p {
            font-size: 14px;
            margin: 5px 0;
        }

        .details {
            text-align: left;
            margin-top: 10px;
            border-top: 1px dashed black;
            padding-top: 10px;
        }

        .total {
            font-size: 16px;
            font-weight: bold;
            border-top: 1px dashed black;
            padding-top: 10px;
            text-align: right;
        }

        .footer {
            font-size: 12px;
            margin-top: 10px;
            border-top: 1px dashed black;
            padding-top: 5px;
            text-align: center;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container text-center">
        <div class="receipt" id="struk">
            <h2><strong>BOOKINGS ID</strong></h2>
            <p>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            <p>ID Booking: <strong>{{ $booking->id }}</strong></p>

            <div class="details">
                <p>Nama: <span class="float-end"><strong>{{ $booking->user->name }}</strong></span></p>
                <p>Tanggal Booking: <span
                        class="float-end"><strong>{{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->translatedFormat('l, d F Y') }}
                        </strong></span>
                </p>
                <p>PlayStation: <span class="float-end"><strong>{{ $booking->playstation->name }}</strong></span></p>
                <p>Durasi: <span class="float-end"><strong>1 Sesi</strong></span></p>
            </div>

            <div class="total">
                <p>Total: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>
                <p class="text-success fw-bold"> LUNAS</p>
            </div>
            <p class="footer">Terima kasih telah menggunakan layanan kami!<br>Unduh struk ini sebagai bukti booking.
            </p>
        </div>
        <div class="p-3 mt-3 text-center shadow-sm card">
            <div class="col2">
                <a href="{{ route('index') }}" class="btn btn-primary">Kembali ke Beranda</a>
                <button class="btn btn-success" onclick="downloadReceipt()">Download Struk</button>
            </div>
        </div>
    </div>

    <script>
        function downloadReceipt() {
            let element = document.getElementById("struk");
            let opt = {
                margin: 5,
                filename: 'Struk_Booking_{{ $booking->user->name }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a6',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
