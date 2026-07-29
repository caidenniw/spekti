<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Prediksi - {{ $user->name }}</title>
    <style>
        * {
            font-family: 'Times New Roman', 'Helvetica', Arial, serif;
            font-size: 12px;
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

        /* === JUDUL LAPORAN === */
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-laporan h1 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 15px 0 5px;
            letter-spacing: 0.5px;
        }

        .judul-laporan h2 {
            font-size: 12px;
            font-weight: normal;
            margin: 0;
            color: #444;
        }

        /* === INFO BOX === */
        .info-box {
            background: #f8f9ff;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            margin-bottom: 20px;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 3px 0;
        }

        .info-box .label {
            color: #737686;
            width: 150px;
            font-size: 11px;
            text-transform: uppercase;
        }

        .info-box .value {
            font-weight: 600;
        }

        /* === RESULT BOX === */
        .result-box {
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
            border: 2px solid #e2e8f0;
        }

        .result-box .percentage {
            font-size: 36px;
            font-weight: 700;
        }

        .result-box .percentage.lulus {
            color: #155724;
        }

        .result-box .percentage.tidak-lulus {
            color: #721c24;
        }

        .result-box .hasil {
            display: inline-block;
            padding: 5px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            margin-top: 8px;
        }

        .result-box .hasil.lulus {
            background: #d4edda;
            color: #155724;
        }

        .result-box .hasil.tidak-lulus {
            background: #f8d7da;
            color: #721c24;
        }

        /* === SECTIONS === */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #004ac6;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin: 20px 0 10px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.data th {
            background: #f1f5f9;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            color: #434655;
            border-bottom: 1px solid #e2e8f0;
        }

        table.data td {
            padding: 7px 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 11px;
        }

        table.data .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 10px;
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

        .saran {
            margin: 15px 0;
        }

        .saran ul {
            margin: 5px 0;
            padding-left: 20px;
        }

        .saran li {
            margin-bottom: 5px;
            font-size: 11px;
            color: #434655;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #737686;
        }

        /* === TANDA TANGAN === */
        .ttd-wrapper {
            page-break-inside: avoid;
            margin-top: 30px;
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
            font-size: 12px;
            margin-bottom: 5px;
        }

        .ttd-block .ttd-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 50px;
            margin-top: 0;
        }

        .ttd-block .ttd-name {
            font-size: 12px;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }

        .ttd-block .ttd-nip {
            font-size: 11px;
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
        <h1>Laporan Prediksi Kelulusan 3,5 Tahun</h1>
        <h2>Sistem Prediksi Tiga Setengah Tahun (SpekTi)</h2>
    </div>

    <!-- INFO MAHASISWA -->
    <div class="info-box">
        <table>
            <tr>
                <td class="label">Nama Mahasiswa</td>
                <td class="value">: {{ $user->name }}</td>
                <td class="label">Tanggal Prediksi</td>
                <td class="value">: {{ $prediction->tanggal_prediksi->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td class="value">: {{ $user->username_nim }}</td>
                <td class="label">Nilai CF Combined</td>
                <td class="value">: {{ number_format($prediction->total_cf_score, 4) }}</td>
            </tr>
            <tr>
                <td class="label">Angkatan</td>
                <td class="value">: {{ $user->angkatan ?? '-' }}</td>
                <td class="label">Jumlah Rule Terpenuhi</td>
                <td class="value">: {{ count($matchedRules) }} dari 49 rule</td>
            </tr>
        </table>
    </div>

    <!-- HASIL PREDIKSI -->
    @php $isLulus = $prediction->hasil_prediksi === 'Lulus 3,5 Tahun'; @endphp
    <div class="result-box">
        <div class="percentage {{ $isLulus ? 'lulus' : 'tidak-lulus' }}">{{ $prediction->persentase_keyakinan }}%</div>
        <div style="font-size:11px;color:#737686;">Tingkat Keyakinan Prediksi</div>
        <div class="hasil {{ $isLulus ? 'lulus' : 'tidak-lulus' }}">{{ $prediction->hasil_prediksi }}</div>
    </div>

    <!-- DATA INPUT KUESIONER -->
    <div class="section-title">Data Input Kuesioner</div>
    <table class="data">
        <tr>
            <th>Variabel</th>
            <th>Kondisi</th>
            <th>CF User</th>
        </tr>
        @php
        $labels = [
        'ipk_status' => 'Indeks Prestasi Kumulatif (IPK)',
        'skripsi_status' => 'Proses Pengerjaan Skripsi',
        'dukungan_keluarga' => 'Dukungan Keluarga',
        'kualitas_dosen' => 'Kualitas Dosen Pembimbing',
        'administrasi' => 'Kelengkapan Administrasi',
        'motivasi_diri' => 'Motivasi Diri',
        'referensi_belajar' => 'Referensi/Sumber Belajar',
        ];
        @endphp
        @foreach($labels as $field => $label)
        <tr>
            <td>{{ $label }}</td>
            <td style="text-transform:capitalize;">{{ str_replace('_', ' ', $prediction->studentVariable->$field) }}</td>
            <td>
                @if($prediction->studentVariable->answers->where('variable_name', $field)->first())
                {{ $prediction->studentVariable->answers->where('variable_name', $field)->first()->cf_user }}
                @else
                -
                @endif
            </td>
        </tr>
        @endforeach
    </table>

    <!-- RULE YANG TERPENUHI -->
    @if(count($matchedRules) > 0)
    <div class="section-title">Rule yang Terpenuhi ({{ count($matchedRules) }})</div>
    <table class="data">
        <tr>
            <th style="width:40px;">Kode</th>
            <th>Deskripsi</th>
            <th style="width:50px;">CF Pakar</th>
            <th style="width:50px;">CF User</th>
            <th style="width:60px;">CF Evidence</th>
            <th style="width:70px;">Status</th>
        </tr>
        @foreach($matchedRules as $mr)
        <tr>
            <td style="font-weight:600;">{{ $mr['kode_rule'] }}</td>
            <td>{{ $mr['deskripsi'] }}</td>
            <td>{{ number_format($mr['cf_pakar'], 2) }}</td>
            <td>{{ number_format($mr['cf_user'], 2) }}</td>
            <td style="font-weight:600;">{{ number_format($mr['cf_evidence'], 4) }}</td>
            <td>
                <span class="badge {{ $mr['status'] === 'Lulus' ? 'lulus' : 'tidak-lulus' }}">{{ $mr['status'] }}</span>
            </td>
        </tr>
        @endforeach
    </table>
    @endif

    <!-- SARAN -->
    @if(count($saran) > 0)
    <div class="section-title">Saran</div>
    <div class="saran">
        <ul>
            @foreach($saran as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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