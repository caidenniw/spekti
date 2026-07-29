# Penjelasan Sistem SpekTi (Sistem Prediksi Tiga Setengah Tahun)

## Apa Itu Project Ini?

**SpekTi** adalah sistem pakar berbasis web untuk memprediksi peluang kelulusan mahasiswa Program Studi Pendidikan Teknik Informatika dan Komputer (PTIK) dalam waktu 3,5 tahun (7 semester). Sistem menggunakan metode **Certainty Factor (CF)** untuk mengolah ketidakpastian dalam pengambilan keputusan akademik.

Dibangun dengan **Laravel 12** (PHP) + **MySQL** + **Bootstrap CDN**. Berjalan di server lokal menggunakan **Laragon**.

---

## Struktur Folder

```
spekti/
│
├── app/                                  ← Kode PHP utama (MVC)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php       ← CRUD Rules + CRUD Mahasiswa + Dashboard + Revisi + Export
│   │   │   ├── AuthController.php        ← Login, Register, Logout
│   │   │   ├── Controller.php            ← Base controller (default Laravel)
│   │   │   ├── StudentController.php     ← Kuesioner, Prediksi, Hasil, Riwayat, Export PDF, Request Edit
│   │   │   └── VariableController.php    ← CRUD Variabel Kuesioner (dinamis via DB)
│   │   └── Middleware/
│   │       └── RoleMiddleware.php        ← Otorisasi berdasarkan role (admin/mahasiswa)
│   ├── Models/
│   │   ├── User.php                      ← Model user (admin/mahasiswa)
│   │   ├── Rule.php                      ← Model rule CF (49 rules)
│   │   ├── StudentVariable.php           ← Model input kuesioner mahasiswa
│   │   ├── StudentAnswer.php             ← Model CF User per variabel
│   │   ├── PredictionResult.php          ← Model hasil prediksi (+ status approval)
│   │   └── Variable.php                  ← Model konfigurasi variabel kuesioner (CRUD dinamis)
│   ├── Providers/
│   │   └── AppServiceProvider.php        ← Config: Pagination Bootstrap 5
│   └── Services/
│       └── CFEngineService.php           ← MESIN UTAMA: logika Certainty Factor
│
├── config/                               ← Konfigurasi Laravel
│   ├── app.php                           ← Setting locale (id), nama app
│   ├── database.php                      ← Konfigurasi MySQL
│   └── ...
│
├── database/
│   ├── migrations/                       ← Struktur database (11 file migrasi)
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_05_31_142540_add_role_and_nim_to_users_table.php
│   │   ├── 2026_05_31_142540_create_rules_table.php
│   │   ├── 2026_05_31_142540_create_student_variables_table.php
│   │   ├── 2026_05_31_142541_create_prediction_results_table.php
│   │   ├── 2026_07_02_000001_remove_mb_md_from_rules_table.php
│   │   ├── 2026_07_02_000002_update_student_variables_table.php
│   │   ├── 2026_07_02_000003_create_student_answers_table.php
│   │   ├── 2026_07_18_000001_add_revision_fields_to_prediction_results.php
│   │   ├── 2026_07_18_000002_add_revision_rejected_to_prediction_results.php
│   │   └── 2026_07_18_000003_create_variables_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php            ← Master seeder
│       ├── UserSeeder.php                ← Seed 1 admin + 4 sample mahasiswa
│       ├── RuleSeeder.php                ← Seed 49 rules dari angket pakar
│       └── VariableSeeder.php            ← Seed 7 variabel kuesioner
│
├── lang/                                 ← Terjemahan Bahasa Indonesia
│   ├── id/
│   │   └── pagination.php                ← "Sebelumnya" / "Berikutnya"
│   ├── id.json                           ← "Menampilkan" / "sampai" / "dari" / "hasil"
│   └── en/
│       └── pagination.php                ← Fallback English
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             ← Template utama (sidebar + content)
│       ├── auth/
│       │   ├── login.blade.php           ← Form login
│       │   └── register.blade.php        ← Form register mahasiswa
│       ├── admin/
│       │   ├── dashboard.blade.php       ← Dashboard analitik admin
│       │   ├── rules.blade.php           ← Daftar 49 rules (tabel + pagination)
│       │   ├── rules-create.blade.php    ← Form tambah rule
│       │   ├── rules-edit.blade.php      ← Form edit rule
│       │   ├── mahasiswa.blade.php       ← Daftar mahasiswa (CRUD)
│       │   ├── mahasiswa-create.blade.php← Form tambah mahasiswa
│       │   ├── mahasiswa-edit.blade.php  ← Form edit mahasiswa
│       │   ├── mahasiswa-detail.blade.php← Detail riwayat prediksi per mahasiswa + export PDF
│       │   ├── revisions.blade.php       ← Daftar permintaan revisi dari mahasiswa
│       │   └── variables/
│       │       ├── index.blade.php       ← Daftar variabel kuesioner
│       │       ├── create.blade.php      ← Form tambah variabel
│       │       └── edit.blade.php        ← Form edit variabel
│       ├── mahasiswa/
│       │   ├── dashboard.blade.php       ← Dashboard mahasiswa
│       │   ├── kuesioner.blade.php       ← Form 7 variabel + CF User
│       │   ├── hasil.blade.php           ← Hasil prediksi + rules + saran
│       │   └── riwayat.blade.php         ← Riwayat semua prediksi
│       └── pdf/
│           ├── prediksi.blade.php        ← Template PDF laporan individu
│           └── rekap.blade.php           ← Template PDF rekap seluruh mahasiswa
│
├── routes/
│   └── web.php                           ← Semua route (auth, admin, mahasiswa)
│
├── docs/
│   ├── angketpakar/                      ← Dokumentasi angket pakar (penelitian)
│   ├── logo/                             ← Aset logo untuk dokumentasi
│   └── catatan.md                        ← File ini
│
├── design.md                             ← Design system (warna, font, layout, komponen)
├── catatan.md                            ← Ringkasan eksekutif (root level — untuk sidang)
├── composer.json                         ← Dependency PHP
├── package.json                          ← Dependency NPM
├── vite.config.js                        ← Config Vite
└── .env                                  ← Setting environment
```

---

## Penjelasan Tiap Komponen Utama

### Controllers

| Controller           | Fungsi                                                                                                  | Route Prefix                     |
| -------------------- | ------------------------------------------------------------------------------------------------------- | -------------------------------- |
| `AuthController`     | Login (NIM + password), Register mahasiswa baru, Logout                                                 | `/login`, `/register`, `/logout` |
| `AdminController`    | Dashboard analitik, CRUD Rules (49 rules), CRUD Mahasiswa, Approval Revisi, Export PDF individu & rekap | `/admin/*`                       |
| `StudentController`  | Dashboard, Form kuesioner, Proses prediksi, Hasil, Riwayat, Export PDF, Request Edit                    | `/mahasiswa/*`                   |
| `VariableController` | CRUD variabel kuesioner (dinamis — dikelola lewat UI admin)                                             | `/admin/variables/*`             |

### Models

| Model              | Tabel                | Fungsi                                                                            |
| ------------------ | -------------------- | --------------------------------------------------------------------------------- |
| `User`             | `users`              | Data pengguna (admin/mahasiswa), relasi ke prediction_results & student_variables |
| `Rule`             | `rules`              | Knowledge base CF (49 rules), cf_pakar langsung dari skala pakar                  |
| `StudentVariable`  | `student_variables`  | Input 7 variabel kuesioner dari mahasiswa                                         |
| `StudentAnswer`    | `student_answers`    | CF User per variabel (keyakinan mahasiswa 1.0/0.8/0.6/0.4/0.2)                    |
| `PredictionResult` | `prediction_results` | Hasil prediksi (CF score, persentase, status, revision fields)                    |
| `Variable`         | `variables`          | Konfigurasi dinamis variabel kuesioner (label, opsi positif/negatif)              |

### CFEngineService (Mesin Utama)

Ini adalah **jantung sistem** — file `CFEngineService.php`.

```
Alur Kerja:
─────────────────────────────────────────

1. Mahasiswa isi kuesioner
   ├── Pilih status 7 variabel (tinggi/rendah, lancar/terlambat, dll)
   └── Pilih tingkat keyakinan per variabel (SY/Y/C/K/TY → 1.0/0.8/0.6/0.4/0.2)
         ↓
2. Simpan ke database
   ├── student_variables (7 status)
   └── student_answers (7 CF User)
         ↓
3. CFEngineService::predict()
   ├── Ambil semua 49 rules dari database
   ├── Untuk setiap rule, cek apakah kondisi terpenuhi
   │   ├── Match → hitung CF_Evidence = CF_Pakar × min(CF_User)
   │   └── Tidak match → skip
   ├── Pisahkan: CF_Lulus vs CF_TidakLulus
   ├── Combine masing-masing grup (rumus iteratif CF)
   └── Bandingkan: mana yang lebih dominan
         ↓
4. Simpan hasil ke prediction_results
   ├── total_cf_score = max(CF_Lulus, CF_TidakLulus)
   ├── persentase_keyakinan = CF × 100
   ├── hasil_prediksi = "Lulus 3,5 Tahun" / "Tidak Lulus 3,5 Tahun"
   └── status = 'active' (default)
         ↓
5. Tampilkan ke user
   ├── Persentase keyakinan
   ├── Rules yang terpenuhi + detail CF
   └── Saran personal (berdasarkan 7 variabel)
```

---

## Struktur Database

### Tabel `users`

| Kolom        | Tipe                      | Keterangan             |
| ------------ | ------------------------- | ---------------------- |
| id           | BIGINT AUTO_INCREMENT     | ID unik                |
| name         | VARCHAR(255)              | Nama lengkap           |
| role         | ENUM('admin','mahasiswa') | Peran pengguna         |
| username_nim | VARCHAR(255) UNIQUE       | NIM (username login)   |
| angkatan     | INT NULL                  | Tahun angkatan         |
| password     | VARCHAR(255)              | Password (bcrypt hash) |
| created_at   | TIMESTAMP                 | Waktu dibuat           |
| updated_at   | TIMESTAMP                 | Waktu update           |

### Tabel `rules`

| Kolom           | Tipe                        | Keterangan                        |
| --------------- | --------------------------- | --------------------------------- |
| id              | BIGINT AUTO_INCREMENT       | ID unik                           |
| kode_rule       | VARCHAR(10) UNIQUE          | Kode rule (R1, R2, ..., R49)      |
| deskripsi_rule  | TEXT                        | Deskripsi IF-THEN                 |
| cf_pakar        | DECIMAL(3,2)                | Nilai CF dari pakar (0.20 - 1.00) |
| status_prediksi | ENUM('Lulus','Tidak Lulus') | Output rule                       |
| created_at      | TIMESTAMP                   | Waktu dibuat                      |
| updated_at      | TIMESTAMP                   | Waktu update                      |

> **Catatan:** Kolom `mb` dan `md` sudah dihapus (migrasi `remove_mb_md_from_rules_table`). CF_Pakar langsung dari skala keyakinan pakar.

### Tabel `variables` (BARU — 18 Juli)

| Kolom         | Tipe                  | Keterangan                                     |
| ------------- | --------------------- | ---------------------------------------------- |
| id            | BIGINT AUTO_INCREMENT | ID unik                                        |
| label         | VARCHAR(255)          | Nama tampilan variabel                         |
| variable_name | VARCHAR(255) UNIQUE   | Key internal (ipk_status, skripsi_status, dsb) |
| positif_value | VARCHAR(255)          | Value opsi positif (tinggi, lancar, dsb)       |
| positif_label | VARCHAR(255)          | Label opsi positif                             |
| negatif_value | VARCHAR(255)          | Value opsi negatif (rendah, terlambat, dsb)    |
| negatif_label | VARCHAR(255)          | Label opsi negatif                             |
| urutan        | INT                   | Urutan tampil di form                          |
| created_at    | TIMESTAMP             | Waktu dibuat                                   |
| updated_at    | TIMESTAMP             | Waktu update                                   |

### Tabel `student_variables`

| Kolom             | Tipe                            | Keterangan                  |
| ----------------- | ------------------------------- | --------------------------- |
| id                | BIGINT AUTO_INCREMENT           | ID unik                     |
| user_id           | BIGINT FK → users.id            | Mahasiswa pemilik           |
| ipk_status        | ENUM('tinggi','rendah')         | IPK (3.51-4.00 / 2.76-3.50) |
| skripsi_status    | ENUM('lancar','terlambat')      | Status skripsi              |
| dukungan_keluarga | ENUM('tinggi','rendah')         | Dukungan keluarga           |
| kualitas_dosen    | ENUM('baik','kurang_baik')      | Kualitas dosen pembimbing   |
| administrasi      | ENUM('lengkap','tidak_lengkap') | Administrasi perkuliahan    |
| motivasi_diri     | ENUM('tinggi','rendah')         | Motivasi diri               |
| referensi_belajar | ENUM('memadai','tidak_memadai') | Referensi/sumber belajar    |
| created_at        | TIMESTAMP                       | Waktu input                 |
| updated_at        | TIMESTAMP                       | Waktu update                |

### Tabel `student_answers`

| Kolom               | Tipe                             | Keterangan                              |
| ------------------- | -------------------------------- | --------------------------------------- |
| id                  | BIGINT AUTO_INCREMENT            | ID unik                                 |
| student_variable_id | BIGINT FK → student_variables.id | Relasi ke input                         |
| variable_name       | VARCHAR(255)                     | Nama variabel (ipk_status, dll)         |
| variable_value      | VARCHAR(255)                     | Nilai yang dipilih (tinggi/rendah, dll) |
| cf_user             | DECIMAL(3,2)                     | Nilai keyakinan (1.0/0.8/0.6/0.4/0.2)   |
| created_at          | TIMESTAMP                        | Waktu dibuat                            |
| updated_at          | TIMESTAMP                        | Waktu update                            |

### Tabel `prediction_results`

| Kolom                 | Tipe                                                            | Keterangan                                  |
| --------------------- | --------------------------------------------------------------- | ------------------------------------------- |
| id                    | BIGINT AUTO_INCREMENT                                           | ID unik                                     |
| user_id               | BIGINT FK → users.id                                            | Mahasiswa                                   |
| student_variable_id   | BIGINT FK → student_variables.id                                | Input kuesioner                             |
| total_cf_score        | DECIMAL(5,4)                                                    | CF Combined (0.0000 - 1.0000)               |
| persentase_keyakinan  | INT                                                             | Persentase (0 - 100)                        |
| hasil_prediksi        | VARCHAR(255)                                                    | "Lulus 3,5 Tahun" / "Tidak Lulus 3,5 Tahun" |
| tanggal_prediksi      | DATE                                                            | Tanggal prediksi                            |
| status                | ENUM('active','pending','revision_allowed','revision_rejected') | Status approval revisi                      |
| revision_requested_at | TIMESTAMP NULL                                                  | Waktu request revisi                        |
| revision_approved_at  | TIMESTAMP NULL                                                  | Waktu approval revisi                       |
| revision_notes        | TEXT NULL                                                       | Alasan revisi                               |
| created_at            | TIMESTAMP                                                       | Waktu dibuat                                |
| updated_at            | TIMESTAMP                                                       | Waktu update                                |

### Relasi Antar Tabel

```
users (admin/mahasiswa)
  ├── student_variables.user_id → users.id (satu mahasiswa banyak input kuesioner)
  ├── prediction_results.user_id → users.id (satu mahasiswa banyak prediksi)
  │
  └── student_answers (melalui student_variables)

student_variables (input kuesioner)
  ├── student_answers.student_variable_id → student_variables.id
  └── prediction_results.student_variable_id → student_variables.id

rules (knowledge base — standalone)
  └── Tidak ada FK (di-read oleh CFEngineService saat prediksi)

variables (konfigurasi kuesioner — standalone)
  └── Tidak ada FK (di-read oleh StudentController untuk render form)
```

---

## Cara Setup / Install

### 1. Persiapan

- Install **Laragon** (Apache + MySQL sudah jalan)
- Install **PHP 8.2+** (sudah include di Laragon)
- Install **Composer** (https://getcomposer.org)
- Install **Node.js** (untuk Vite build)

### 2. Copy Project

```
Copy folder project ke: C:\laragon\www\spekti
```

### 3. Install Dependency

```bash
cd C:\laragon\www\spekti
composer install
npm install && npm run build
```

### 4. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Pastikan setting database di `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spekti_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Database & Jalankan Migrasi

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

Ini akan:

- Membuat database `spekti_db`
- Membuat semua tabel
- Insert data: 1 admin, 4 sample mahasiswa, 49 rules, 7 variabel

### 6. Jalankan Server

```bash
php artisan serve
```

Buka: `http://localhost:8000` atau `http://spekti.test` (via Laragon)

---

## Akun Default

| Role      | NIM/Username | Password |
| --------- | ------------ | -------- |
| Admin     | admin        | password |
| Mahasiswa | 2022001      | password |
| Mahasiswa | 2022002      | password |
| Mahasiswa | 2023001      | password |
| Mahasiswa | 2023002      | password |

> **Catatan:** Dummy data mahasiswa (50 mahasiswa) sudah dihapus. Admin harus membuat data mahasiswa manual lewat panel admin.

---

## Alur Fitur Utama

### Alur Login

```
1. User buka http://spekti.test → redirect ke /login
2. Input NIM/Username + Password
3. Sistem cek ke database (bcrypt verify)
4. Jika cocok → set session + redirect berdasarkan role:
   ├── admin → /admin/dashboard
   └── mahasiswa → /mahasiswa/dashboard
5. Jika salah → error "NIM atau Password salah"
```

### Alur Prediksi (Mahasiswa)

```
1. Mahasiswa klik menu "Kuesioner"
2. Form 7 variabel muncul:
   ├── IPK: Tinggi / Rendah
   ├── Skripsi: Lancar / Terlambat
   ├── Dukungan Keluarga: Tinggi / Rendah
   ├── Kualitas Dosen: Baik / Kurang Baik
   ├── Administrasi: Lengkap / Tidak Lengkap
   ├── Motivasi Diri: Tinggi / Rendah
   └── Referensi Belajar: Memadai / Tidak Memadai
3. Untuk setiap variabel, pilih "Tingkat Keyakinan":
   ├── Sangat Yakin (1.0)
   ├── Yakin (0.8)
   ├── Cukup Yakin (0.6)
   ├── Kurang Yakin (0.4)
   └── Tidak Yakin (0.2)
4. Klik "Proses Prediksi"
5. Sistem:
   ├── Simpan 7 status ke student_variables
   ├── Simpan 7 CF User ke student_answers
   ├── CFEngineService::predict() → hitung CF
   └── Simpan hasil ke prediction_results (status: active)
6. Redirect ke halaman hasil prediksi
7. Tampilkan:
   ├── Persentase keyakinan
   ├── Status: "Lulus 3,5 Tahun" / "Tidak Lulus 3,5 Tahun"
   ├── Detail rules yang match (CF Pakar × CF User)
   ├── Saran personal (7 tips berdasarkan variabel)
   └── Tombol "Export PDF"
```

### Alur Revisi Prediksi (Mahasiswa Request → Admin Approve)

```
1. Mahasiswa punya prediksi aktif → ingin ubah data
2. Klik "Ajukan Revisi" → isi alasan (min 10 karakter)
3. Status prediksi berubah: active → pending
4. Admin lihat di menu "Revisi" → daftar permintaan
5. Admin bisa:
   ├── APPROVE → status jadi revision_allowed → mahasiswa bisa edit kuesioner
   └── REJECT  → status jadi revision_rejected → mahasiswa lihat penolakan
6. Jika di-approve:
   ├── Mahasiswa klik "Kuesioner" lagi (mode edit)
   ├── Form terisi data lama
   ├── Ubah data → submit
   ├── Sistem hitung ulang CF
   ├── Update prediction_result yang SAMA → status kembali active
   └── Redirect ke hasil baru
```

### Alur Admin Kelola Rules

```
1. Admin klik menu "Rules CF"
2. Tabel 49 rules ditampilkan (R1 - R49, sorting numerik)
3. Bisa: Tambah, Edit, Hapus rule
4. Form rule:
   ├── Kode Rule (auto: R001, R002, ...)
   ├── Deskripsi Rule (IF-THEN)
   ├── CF Pakar (dropdown: SY/Y/C/K/TY → 1.0/0.8/0.6/0.4/0.2)
   └── Status Prediksi (Lulus / Tidak Lulus)
```

### Alur Admin Kelola Variabel

```
1. Admin klik menu "Variabel"
2. Daftar 7 variabel kuesioner ditampilkan
3. Bisa: Tambah, Edit, Hapus variabel
4. Form variabel:
   ├── Label (nama tampilan)
   ├── Variable Name (key internal)
   ├── Opsi Positif (value + label)
   ├── Opsi Negatif (value + label)
   └── Urutan
```

### Alur Export PDF

```
1. User klik tombol "Export PDF"
2. Ada 2 jenis PDF:
   ├── Individu (mahasiswa) → Laporan prediksi per mahasiswa
   │   Header kop UIN → Info mahasiswa → Hasil prediksi
   │   → Tabel input → Tabel rules match → Saran → TTD Ketua Prodi
   └── Rekap (admin) → Rekap seluruh mahasiswa
       Header kop UIN → Ringkasan (total/lulus/tidak) → Tabel data → TTD
3. Browser download file PDF
```

---

## Logika Certainty Factor (CF)

### Rumus yang Digunakan

```
1. CF_Pakar = nilai dari pakar (0.20 - 1.00)
   (langsung dari skala: SY=1.0, Y=0.8, C=0.6, K=0.4, TY=0.2)

2. CF_User = keyakinan mahasiswa (0.20 - 1.00)
   (dipilih sendiri dari dropdown per variabel)

3. CF_Evidence = CF_Pakar × CF_User
   (jika rule punya banyak kondisi, CF_User = minimum dari semua variabel)

4. CF_Combine = gabungan beberapa CF_Evidence (rumus iteratif):
   CF = CF1 + CF2 × (1 - CF1) + CF3 × (1 - CF_prev) + ...

5. Pisahkan CF_Lulus dan CF_TidakLulus:
   ├── Rules Lulus → di-combine → CF_Lulus
   └── Rules Tidak Lulus → di-combine → CF_TidakLulus

6. Hasil Prediksi:
   ├── CF_Lulus > CF_TidakLulus → "Lulus 3,5 Tahun"
   └── CF_TidakLulus >= CF_Lulus → "Tidak Lulus 3,5 Tahun"

7. Persentase = max(CF_Lulus, CF_TidakLulus) × 100
```

### 7 Variabel Prediksi

| No  | Variabel          | Positif              | Negatif              |
| --- | ----------------- | -------------------- | -------------------- |
| 1   | IPK               | Tinggi (3.51 - 4.00) | Rendah (2.76 - 3.50) |
| 2   | Skripsi           | Lancar               | Terlambat            |
| 3   | Dukungan Keluarga | Tinggi               | Rendah               |
| 4   | Kualitas Dosen    | Baik                 | Kurang Baik          |
| 5   | Administrasi      | Lengkap              | Tidak Lengkap        |
| 6   | Motivasi Diri     | Tinggi               | Rendah               |
| 7   | Referensi Belajar | Memadai              | Tidak Memadai        |

### 49 Rules (dari Angket Pakar)

| Kode      | Kategori                                                 | Jumlah |
| --------- | -------------------------------------------------------- | ------ |
| R1-R7     | IPK Tinggi + variabel lain → Lulus                       | 7      |
| R8-R14    | Skripsi Terlambat + variabel lain → Tidak Lulus          | 7      |
| R15-R21   | Dukungan Keluarga Tinggi + variabel lain → Lulus         | 7      |
| R22-R28   | Kualitas Dosen Kurang Baik + variabel lain → Tidak Lulus | 7      |
| R29-R35   | Administrasi Lengkap + variabel lain → Lulus             | 7      |
| R36-R42   | Motivasi Rendah + variabel lain → Tidak Lulus            | 7      |
| R43-R49   | Referensi Memadai + variabel lain → Lulus                | 7      |
| **Total** |                                                          | **49** |

---

## Fitur Sistem

### Admin

- Dashboard analitik (total mahasiswa, rules, prediksi, persentase lulus, per angkatan)
- CRUD Rules Knowledge Base (49 rules)
- CRUD Variabel Kuesioner (7 variabel dinamis)
- CRUD Data Mahasiswa (tambah, edit, hapus)
- Detail riwayat prediksi per mahasiswa + export PDF individu
- Export rekap PDF seluruh mahasiswa (filter: semua/lulus/tidak lulus)
- Approval/reject permintaan revisi prediksi dari mahasiswa

### Mahasiswa

- Dashboard ringkasan
- Form kuesioner (7 variabel + CF User) — one prediction
- Lihat hasil prediksi (persentase, rules match, saran)
- Ajukan permintaan revisi data prediksi
- Riwayat semua prediksi
- Export PDF per prediksi

---

## Stack Teknologi

| Komponen   | Teknologi                                         |
| ---------- | ------------------------------------------------- |
| Backend    | PHP 8.2+ / Laravel 12                             |
| Database   | MySQL (via Laragon) — DB: `spekti_db`             |
| Frontend   | Bootstrap CDN 5.3.3 + Bootstrap Icons             |
| Font       | Inter (Google Fonts)                              |
| PDF Export | barryvdh/laravel-dompdf                           |
| Icons      | Bootstrap Icons                                   |
| Template   | Blade Laravel                                     |
| Server     | Laragon (Apache + MySQL) atau `php artisan serve` |

---

## Catatan Penting

1. **49 rules** diambil langsung dari angket pakar (bukan dari proposal yang hanya 10 rules)
2. **CF_Pakar** langsung dari skala keyakinan pakar (SY/Y/C/K/TY), bukan dari MB-MD (kolom mb/md sudah dihapus)
3. **Persentase** selalu tinggi (95-100%) karena 49 rules yang match banyak → ini normal untuk sistem dengan banyak rules
4. **Warna** hasil prediksi berdasarkan STATUS (Lulus/Tidak Lulus), bukan angka persentase
5. **Role** hanya 2: Admin dan Mahasiswa (role Pakar sudah dihapus)
6. **Locale** Bahasa Indonesia (`id`)
7. **Pagination** Bootstrap 5
8. **One Prediction** — mahasiswa hanya punya SATU prediksi aktif. Untuk mengubah data, harus melalui flow revisi (request → admin approve → edit)
9. **Revisi Flow** — status yang tersedia: `active` (final), `pending` (menunggu approval), `revision_allowed` (disetujui admin), `revision_rejected` (ditolak admin)
10. **Variabel dinamis** — 7 variabel dikelola lewat tabel `variables`, bisa ditambah/diedit lewat UI admin (tidak hardcode)
11. **Data dummy dihapus** — `MahasiswaDummySeeder` (50 mahasiswa) sudah dihapus. Admin input manual
12. **Storage link** — sudah dibuat (`public/storage` → `storage/app/public`)
13. **TTD PDF** — menggunakan `public/images/ttd-ketua-prodi.jpg` dan `public/images/logo-uin.jpg`
14. **No git repo** — backup manual
