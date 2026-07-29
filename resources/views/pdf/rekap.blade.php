<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Rekap Prediksi Kelulusan - {{ ucfirst($filter) }}</title>
    <style>
        * {
            font-family: 'Times New Roman', 'Helvetica', Arial, serif;
            font-size: 11px;
            color: #1a1a1a;
        }

        body {
            margin: 0;
            padding: 20px;
        }

        /* === KOP SURAT === */
        .kop-surat {
            border-top: 3px solid #000;
            border-bottom: 3px solid #000;
            padding: 10px 0;
            margin-bottom: 15px;
            display: table;
            width: 100%;
        }

        .kop-logo {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            text-align: center;
            padding-right: 10px;
        }

        .kop-logo img {
            width: 75px;
            height: auto;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .kop-text .kemenag {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            line-height: 1.3;
        }

        .kop-text .universitas {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 2px 0;
            line-height: 1.3;
        }

        .kop-text .fakultas {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 2px 0;
            line-height: 1.3;
        }

        .kop-text .prodi {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin: 2px 0;
            line-height: 1.3;
        }

        .kop-text .alamat {
            font-size: 9px;
            color: #333;
            margin: 3px 0 0;
            line-height: 1.4;
        }

        /* === JUDUL === */
        .judul-laporan {
            text-align: center;
            margin-bottom: 15px;
        }

        .judul-laporan h1 {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 12px 0 5px;
            letter-spacing: 0.5px;
        }

        .judul-laporan h2 {
            font-size: 11px;
            font-weight: normal;
            margin: 0;
            color: #444;
        }

        /* === RINGKASAN === */
        .ringkasan {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .ringkasan-box {
            display: table-cell;
            width: 33%;
            text-align: center;
            padding: 8px;
            border: 1px solid #e2e8f0;
        }

        .ringkasan-box .angka {
            font-size: 22px;
            font-weight: 700;
        }

        .ringkasan-box .label {
            font-size: 9px;
            color: #737686;
            text-transform: uppercase;
        }

        .ringkasan-box .angka.total {
            color: #004ac6;
        }

        .ringkasan-box .angka.lulus {
            color: #155724;
        }

        .ringkasan-box .angka.tidak-lulus {
            color: #721c24;
        }

        /* === TABEL === */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.data th {
            background: #f1f5f9;
            padding: 6px 8px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            color: #434655;
            border: 1px solid #e2e8f0;
        }

        table.data td {
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }

        table.data .badge {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: 600;
        }

        table.data .badge.lulus {
            background: #d4edda;
            color: #155724;
        }

        table.data .badge.tidak-lulus {
            background: #f8d7da;
            color: #721c24;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 9px;
            color: #737686;
        }

        /* === TANDA TANGAN === */
        .ttd-wrapper {
            page-break-inside: avoid;
            margin-top: 20px;
            display: table;
            width: 100%;
        }

        .ttd-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .ttd-block {
            text-align: left;
        }

        .ttd-col:last-child .ttd-block {
            padding-left: 20%;
        }

        .ttd-block .ttd-date {
            font-size: 11px;
            margin-bottom: 5px;
        }

        .ttd-block .ttd-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 50px;
            margin-top: 0;
        }

        .ttd-block .ttd-name {
            font-size: 11px;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }

        .ttd-block .ttd-nip {
            font-size: 10px;
            margin: 2px 0 0;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <!-- KOP SURAT -->
    <div class="kop-surat">
        <div class="kop-logo">
            <img src="{{ public_path('images/logo-uin.jpg') }}" alt="Logo UIN">
        </div>
        <div class="kop-text">
            <p class="kemenag">Kementerian Agama Republik Indonesia</p>
            <p class="universitas">Universitas Islam Negeri Sjech M. Djamil Djambek Bukittinggi</p>
            <p class="fakultas">Fakultas Tarbiyah dan Ilmu Keguruan</p>
            <p class="prodi">Program Studi Pendidikan Teknik Informatika dan Komputer</p>
            <p class="alamat">
                Kampus II : Jalan Gurun Aur, Kubang Putih — Kabupaten Agam - Sumatera Barat 26181<br>
                Website: uinbukittinggi.ac.id | Email: ftik.uinbukittinggi.ac.id
            </p>
        </div>
    </div>

    <!-- JUDUL LAPORAN -->
    <div class="judul-laporan">
        <h1>Rekap Prediksi Kelulusan 3,5 Tahun</h1>
        <h2>
            @if($filter === 'semua')
            Seluruh Mahasiswa
            @elseif($filter === 'lulus')
            Mahasiswa Lulus 3,5 Tahun
            @else
            Mahasiswa Tidak Lulus 3,5 Tahun
            @endif
            — {{ now()->format('d F Y') }}
        </h2>
    </div>

    <!-- RINGKASAN -->
    <div class="ringkasan">
        <div class="ringkasan-box">
            <div class="angka total">{{ $totalMahasiswa }}</div>
            <div class="label">Total Mahasiswa</div>
        </div>
        <div class="ringkasan-box">
            <div class="angka lulus">{{ $lulusCount }}</div>
            <div class="label">Lulus 3,5 Tahun</div>
        </div>
        <div class="ringkasan-box">
            <div class="angka tidak-lulus">{{ $tidakLulusCount }}</div>
            <div class="label">Tidak Lulus 3,5 Tahun</div>
        </div>
    </div>

    <!-- TABEL DATA -->
    <table class="data">
        <tr>
            <th style="width:30px;">No</th>
            <th>Nama Mahasiswa</th>
            <th style="width:75px;">NIM</th>
            <th style="width:45px;">Angkatan</th>
            <th style="width:50px;">CF Score</th>
            <th style="width:45px;">Persen</th>
            <th style="width:85px;">Hasil Prediksi</th>
            <th style="width:70px;">Tanggal</th>
        </tr>
        @foreach($predictions as $i => $pred)
        <tr>
            <td style="text-align:center;">{{ $i + 1 }}</td>
            <td>{{ $pred->user->name }}</td>
            <td>{{ $pred->user->username_nim }}</td>
            <td style="text-align:center;">{{ $pred->user->angkatan }}</td>
            <td style="text-align:center;">{{ number_format($pred->total_cf_score, 4) }}</td>
            <td style="text-align:center;">{{ $pred->persentase_keyakinan }}%</td>
            <td>
                <span class="badge {{ $pred->hasil_prediksi === 'Lulus 3,5 Tahun' ? 'lulus' : 'tidak-lulus' }}">
                    {{ $pred->hasil_prediksi === 'Lulus 3,5 Tahun' ? 'Lulus' : 'Tidak Lulus' }}
                </span>
            </td>
            <td style="text-align:center;">{{ $pred->tanggal_prediksi->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </table>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper clearfix">
        <div class="ttd-col">
            <div class="ttd-block">
                <p class="ttd-date">Bukittinggi, {{ now()->format('d F Y') }}</p>
                <p class="ttd-title">Ketua Prodi</p>
                <div style="height: 70px;"></div>
                <p class="ttd-name">Sarwo Derta, S.S. S.Kom, M.Kom</p>
                <p class="ttd-nip">NIP. 197501042006041003</p>
            </div>
        </div>
        <div class="ttd-col">
            <div class="ttd-block">
                <p class="ttd-date">Bukittinggi, {{ now()->format('d F Y') }}</p>
                <p class="ttd-title">Dosen Pembimbing Akademik</p>
                <div style="height: 70px;"></div>
                <p class="ttd-name" style="text-decoration:none;">&nbsp;</p>
                <p class="ttd-nip">&nbsp;</p>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Dicetak pada {{ now()->format('d F Y H:i') }} — Sistem Prediksi Tiga Setengah Tahun (SpekTi)
    </div>
</body>

</html>