<!DOCTYPE html>
<html>

<head>
    <title>Kartu Tanda Mahasiswa Sementara</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            text-align: center;
        }

        .card {
            width: 15cm;
            /* Ukuran lebar kartu agak besar agar jelas */
            height: 9.5cm;
            border: 2px solid #333;
            margin: 0 auto;
            position: relative;
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            border-bottom: 2px double #004085;
            padding-bottom: 10px;
            margin-bottom: 15px;
            color: #004085;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            text-decoration: underline;
        }

        .content {
            display: table;
            width: 100%;
            text-align: left;
            margin-top: 10px;
        }

        .photo-area {
            display: table-cell;
            width: 30%;
            vertical-align: top;
            text-align: center;
        }

        .photo-box {
            width: 3cm;
            height: 4cm;
            background-color: #ddd;
            border: 1px solid #999;
            margin: 0 auto;
            object-fit: cover;
        }

        .details {
            display: table-cell;
            width: 70%;
            vertical-align: top;
            padding-left: 15px;
        }

        .row {
            margin-bottom: 8px;
            font-size: 12px;
        }

        .label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
            padding-right: 20px;
        }

        .footer p {
            margin: 2px;
        }

        .note {
            margin-top: 30px;
            font-size: 9px;
            color: #666;
            text-align: center;
            font-style: italic;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 60px;
            color: rgba(0, 0, 0, 0.05);
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            {{-- Watermark --}}
            <div class="watermark">KTM SEMENTARA</div>

            {{-- Header Kampus --}}
            <div class="header">
                {{-- Ganti src dengan public_path('images/logo.png') jika ada logo --}}
                {{-- <img src="{{ public_path('images/logo.png') }}" style="height: 40px; float: left;"> --}}
                <h2>WISE UNIVERSITY</h2>
                <p>Jl. Pendidikan No. 123, Kota Teknologi</p>
                <p>Telepon: (+62) 21 1234 5678</p>
            </div>

            <div class="title">KARTU TANDA MAHASISWA SEMENTARA</div>

            <div class="content">


                {{-- Detail Mahasiswa --}}
                <div class="details">
                    <div class="row">
                        <span class="label">ID Pendaftaran</span>: #{{ $pendaftaran->id }}
                    </div>
                    <div class="row">
                        <span class="label">Nama Lengkap</span>: {{ strtoupper($pendaftaran->full_name) }}
                    </div>
                    <div class="row">
                        <span class="label">Program Studi</span>: {{ $pendaftaran->prodi->nama_prodi ?? '-' }}
                    </div>
                    <div class="row">
                        <span class="label">Jenjang</span>: S1 (Sarjana)
                    </div>
                    <div class="row">
                        <span class="label">Tempat/Tgl Lahir</span>: {{ $pendaftaran->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d-m-Y') }}
                    </div>
                    <div class="row">
                        <span class="label">Berlaku Hingga</span>: {{ now()->addMonths(1)->format('d F Y') }}
                    </div>
                </div>
            </div>

        </div>


    </div>

</body>

</html>