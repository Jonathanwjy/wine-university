<!DOCTYPE html>
<html>

<head>
    <title>Detail Pendaftaran Mahasiswa</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
        }

        .section-title {
            background-color: #eee;
            padding: 5px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td {
            padding: 6px;
            vertical-align: top;
        }

        .label {
            width: 30%;
            font-weight: bold;
        }

        .colon {
            width: 2%;
        }

        .value {
            width: 68%;
        }

        .status-box {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .signatures {
            margin-top: 40px;
            width: 100%;
        }

        .sig-box {
            width: 45%;
            float: left;
            text-align: center;
        }

        .sig-box.right {
            float: right;
        }
    </style>
</head>

<body>

    <div class="header">
        {{-- Ganti dengan path logo kampus Anda --}}
        {{-- <img src="{{ public_path('images/logo.png') }}" width="60" style="display:block; margin: 0 auto 10px;"> --}}
        <h1>Universitas Teknologi Masa Depan</h1>
        <p>Jl. Pendidikan No. 123, Jakarta Selatan, Indonesia</p>
        <p>Formulir Biodata Pendaftaran Mahasiswa Baru</p>
    </div>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 50%">
                <strong>No. Registrasi:</strong> #{{ $pendaftaran->id }}<br>
                <strong>Tanggal Daftar:</strong> {{ $pendaftaran->created_at->format('d F Y H:i') }}
            </td>

        </tr>
    </table>

    <div class="section-title">A. DATA PRIBADI</div>
    <table>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td class="value">{{ strtoupper($pendaftaran->full_name) }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="colon">:</td>
            <td class="value">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="label">Tempat, Tanggal Lahir</td>
            <td class="colon">:</td>
            <td class="value">{{ $pendaftaran->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Telepon / WA</td>
            <td class="colon">:</td>
            <td class="value">{{ $pendaftaran->nomor_telepon }}</td>
        </tr>
        <tr>
            <td class="label">Email Akun</td>
            <td class="colon">:</td>
            <td class="value">{{ $pendaftaran->user->email ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Lengkap</td>
            <td class="colon">:</td>
            <td class="value">{{ $pendaftaran->alamat }}</td>
        </tr>
    </table>

    <div class="section-title">B. DATA AKADEMIK & PILIHAN</div>
    <table>
        <tr>
            <td class="label">Program Studi Pilihan</td>
            <td class="colon">:</td>
            <td class="value">{{ $pendaftaran->prodi->nama_prodi ?? 'Tidak Diketahui' }} (S1)</td>
        </tr>
        <tr>
            <td class="label">Pendidikan Terakhir</td>
            <td class="colon">:</td>
            <td class="value">{{ $pendaftaran->pendidikan_terakhir }}</td>
        </tr>
    </table>

    <div class="section-title">C. STATUS ADMINISTRASI</div>
    <table>
        <tr>
            <td class="label">Status Pendaftaran</td>
            <td class="colon">:</td>
            <td class="value" style="text-transform: uppercase;">
                DITERIMA
            </td>
        </tr>
        <tr>
            <td class="label">Status Pembayaran</td>
            <td class="colon">:</td>
            <td class="value">
                LUNAS
            </td>
        </tr>
    </table>

    <div class="signatures">
        <div class="sig-box">
            <p>Petugas Pendaftaran,</p>
            <br><br><br>
            <p>( ...................................... )</p>
        </div>
        <div class="sig-box right">
            <p>Palembang, {{ date('d F Y') }}</p>
            <p>Calon Mahasiswa,</p>
            <br><br><br>
            <p>( {{ $pendaftaran->full_name }} )</p>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div style="margin-top: 50px; font-size: 10px; color: #555; text-align: center; border-top: 1px solid #ccc; padding-top: 5px;">
        Dokumen ini digenerate otomatis oleh Sistem Informasi PMB pada {{ now()->format('d/m/Y H:i:s') }}.
    </div>

</body>

</html>