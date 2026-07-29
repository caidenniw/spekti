<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tidak Lulus 3,5 Tahun - {{ $user->name }}</title>
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

        /* === KOP SURAT (sama persis dengan prediksi) === */
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

        /* === JUDUL (sama persis dengan prediksi) === */
        .judul-laporan {
            text-align: center;
            margin: 20px 0 15px;
        }
        .judul-laporan h1 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
            letter-spacing: 0.5px;
        }

        /* === SECTION TITLE (sama persis dengan prediksi) === */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #004ac6;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin: 20px 0 10px;
        }

        /* === INFO BOX (sama persis dengan prediksi) === */
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
            width: 140px;
            font-size: 11px;
        }
        .info-box .value {
            font-weight: 600;
        }

        /* === ISI SURAT === */
        .body-text {
            margin: 15px 0;
            text-align: justify;
            line-height: 2;
        }
        .body-text p {
            margin: 0 0 8px;
            font-size: 12px;
            text-indent: 40px;
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
            padding-top: 0;
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

        /* === FOOTER (sama persis dengan prediksi) === */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #737686;
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

    <!-- JUDUL -->
    <div class="judul-laporan">
        <h1>Surat Keterangan Tidak Lulus 3,5 Tahun</h1>
    </div>

    <!-- PEMBUKA -->
    <div class="body-text">
        <p>
            Yang bertanda tangan di bawah ini menerangkan bahwa mahasiswa Program Studi Pendidikan Teknik Informatika dan Komputer, Fakultas Tarbiyah dan Ilmu Keguruan, Universitas Islam Negeri Sjech M. Djamil Djambek Bukittinggi, dengan data sebagai berikut:
        </p>
    </div>

    <!-- INFO MAHASISWA (sama style info-box dengan prediksi) -->
    <div class="info-box">
        <table>
            <tr>
                <td class="label">Nama Mahasiswa</td>
                <td class="value">: {{ $user->name }}</td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td class="value">: {{ $user->username_nim }}</td>
            </tr>
            <tr>
                <td class="label">Angkatan</td>
                <td class="value">: {{ $user->angkatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Program Studi</td>
                <td class="value">: Pendidikan Teknik Informatika dan Komputer (PTIK)</td>
            </tr>
        </table>
    </div>

    <!-- ISI -->
    <div class="body-text">
        <p>
            Bahwa berdasarkan hasil pemeriksaan nilai akademik, mahasiswa tersebut <strong>memiliki nilai C, D, atau E</strong> pada beberapa mata kuliah, sehingga <strong>tidak memenuhi syarat</strong> untuk mengikuti prediksi kelulusan 3,5 tahun melalui Sistem Prediksi Tiga Setengah Tahun (SpekTi).
        </p>
        <p>
            Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper">
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
