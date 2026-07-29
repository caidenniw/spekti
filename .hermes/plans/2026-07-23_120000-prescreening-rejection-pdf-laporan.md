---
date: 2026-07-23
tags: [spekti, prescreening, pdf, laporan]
status: plan
---

# Plan: Laporan PDF untuk Mahasiswa Tidak Lulus Pre-screening (Nilai C/D/E)

## 1. Goal

Mahasiswa yang menjawab "Tidak, ada nilai C, D, atau E" pada pre-screening tetap bisa mengunduh **Laporan Keterangan Tidak Lulus 3,5 Tahun** dalam format PDF — sebagai bukti/surat keterangan resmi.

## 2. Current Context

- Pre-screening (`pre_screenings` table): kolom `nilai_ab_only` (boolean). `false` = ada nilai C/D/E.
- Saat mahasiswa submit `nilai_ab_only=false` → redirect ke view `prescreening-rejected.blade.php` → hanya info + saran + tombol ke dashboard.
- Tidak ada tombol download PDF di halaman reject.
- Tidak ada route/controller method untuk generate PDF khusus pre-screening rejection.
- PDF existing (`pdf.prediksi`) menggunakan DomPDF, kop UIN, TTD 2 kolom (Dosen PA + KProdi).

## 3. Proposed Approach

### 3.1. Buat PDF view baru: `resources/views/pdf/prescreening-rejected.blade.php`

- Copy struktur dari `pdf.prediksi` (kop UIN, TTD 2 kolom)
- Konten: surat keterangan bahwa mahasiswa TIDAK LULUS 3,5 Tahun karena memiliki nilai C/D/E
- Data yang ditampilkan: nama, NIM, angkatan, pernyataan tidak lolos pre-screening, tanggal cetak
- TTD: Dosen PA (kosong) + KProdi (Sarwo Derta, S.S. S.Kom, M.Kom)

### 3.2. Tambah method di `StudentController`: `exportPreScreeningPdf()`

- Ambil data `PreScreening` milik user yang login
- Validasi: pre-screening harus ada & `nilai_ab_only = false`
- Load view PDF dengan data user + pre-screening
- Return download PDF

### 3.3. Tambah route: `mahasiswa.export-prescreening-pdf`

- `GET /mahasiswa/export-prescreening-pdf`
- Middleware: auth, role:mahasiswa (sama seperti route mahasiswa lainnya)

### 3.4. Update view `prescreening-rejected.blade.php`

- Tambah tombol/button "Download Laporan Keterangan" yang mengarah ke route export
- Simpan desain yang existing (± info + saran), tambah aja tombol download di area yang tepat

### 3.5. (Optional) Admin: tambah kolom aksi download di halaman pre-screening log

- Di `admin.prescreening` view (AdminController@preScreeningIndex) — tampilkan tombol download per mahasiswa yang ditolak

## 4. Files Likely to Change

| File | Change |
|------|--------|
| `resources/views/pdf/prescreening-rejected.blade.php` | **NEW** — template PDF laporan tidak lulus |
| `app/Http/Controllers/StudentController.php` | **EDIT** — tambah method `exportPreScreeningPdf()` |
| `routes/web.php` | **EDIT** — tambah route export pre-screening |
| `resources/views/mahasiswa/prescreening-rejected.blade.php` | **EDIT** — tambah tombol download |
| `resources/views/admin/prescreening.blade.php` | **EDIT** — tambah tombol download per mahasiswa (optional) |

## 5. Tests / Validation

A. Buka /mahasiswa/prescreening → klik "Tidak, ada nilai C, D, atau E"
B. Halaman reject muncul → klik tombol download
C. PDF terdownload dengan kop UIN, data mahasiswa, pernyataan tidak lulus, TTD 2 kolom
D. Login sebagai mahasiswa yang lolos pre-screening → route export pre-screening tidak bisa diakses (403/redirect)
E. Admin: buka /admin/prescreening → lihat log + tombol download

## 6. Risks & Open Questions

- **Data PreScreening tidak punya relasi ke PredictionResult** — jadi PDF ini murni berdasarkan pre-screening saja, bukan hasil CF. Sesuai keinginan client.
- **Format TTD** — Dosen PA tetap dikosongkan (sama seperti PDF prediksi existing), KProdi diisi Sarwo Derta.
- **Nama file PDF** — usulan: `Surat_Keterangan_Tidak_Lulus_3.5_Tahun_{NIM}_{tanggal}.pdf`
- **Apakah PDF ini perlu nomor surat?** — Asumsi tidak, sesuai format existing.

## 7. Implementation Order

1. Buat PDF template
2. Tambah method controller
3. Tambah route
4. Update view reject dengan tombol
5. Update admin log (optional)
6. Test end-to-end
