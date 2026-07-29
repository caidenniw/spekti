---
date: 2026-07-22
tags: [spekti, pdf, ttd, fix]
status: in-progress
---

# Analisis Issue TTD Terpotong di PDF SpekTi

## Temuan Awal

Dari memori sebelumnya, issue pertama adalah **tanda tangan terpotong di PDF DomPDF** — khususnya pada `pdf.rekap` yang menggunakan `page-break: avoid`.

## Verifikasi Kode

### 1. `pdf/rekap.blade.php` — Rekap PDF (A4 Landscape)

**Tanda tangan ada di baris 202-210:**

```css
.ttd-wrapper {
    page-break-inside: avoid;
    margin-top: 20px;
}

.ttd-block {
    text-align: left;
    width: 280px;
    margin-left: auto;
    margin-right: -20px;    /* ← POTENSIAL ISSUE: margin negatif di DomPDF */
}
```

- Sudah menggunakan `page-break-inside: avoid` — **AMAN**.
- Struktur ttd-block ada di baris 325-333.

### 2. `pdf/prediksi.blade.php` — PDF Individu (A4 Portrait)

**Tanda tangan di baris 255-265:**

```css
.ttd-wrapper {
    page-break-inside: avoid;
    margin-top: 30px;
}

.ttd-block {
    text-align: left;
    width: 280px;
    margin-left: auto;
    margin-right: -20px;   /* ← SAMA: margin negatif */
}
```

- Ada juga `.ttd-image` (line 278) untuk gambar tanda tangan — meski path belum diisi.
- Juga menggunakan `page-break-inside: avoid`.

### 3. Controller — `AdminController.php`

- `exportRekap()` (line 352): A4 **landscape** → kemungkinan TTD terpotong karena space horizontal
- `generateManualPrediction()` (line 320): A4 **portrait** → lebih kecil risiko terpotong
- Keduanya menggunakan `Barryvdh\DomPDF\Facade\Pdf`

## Analisis Root Cause

Issue **margin-right: -20px** pada `.ttd-block`:
- Nilai `margin-right: -20px` bisa menyebabkan DomPDF salah perhitungan bounding box di posisi `margin-left: auto`.
- Jika tabel data memakan banyak halaman, `.ttd-wrapper` dengan `page-break-inside: avoid` bisa terdorong ke bawah dan tabrakan dengan batas halaman.

## Status Fix

- `page-break-inside: avoid` → SUDAH ADA, tepatnya sebagai pencegahan.
- `margin-right: -20px` → Masih ada, ini bisa jadi penyebab TTD terpotong dikanan karena DomPDF kurang handle margin negatif dengan baik.
- `margin-bottom: 50px` pada `.ttd-title` memberi ruang untuk ttd — ini OK.
- Ukuran kertas A4 landscape untuk rekap seharusnya cukup lebar.
