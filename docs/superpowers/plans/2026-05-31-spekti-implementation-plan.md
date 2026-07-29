# SpekTi Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun sistem prediksi kelulusan mahasiswa 3,5 tahun dengan metode Certainty Factor (CF).

**Architecture:** Menggunakan pola Service Layer (`CFEngineService`) untuk logika prediksi, dengan persistensi data menggunakan Model Laravel dan struktur database relasional.

**Tech Stack:** Laravel, MySQL, Eloquent ORM.

---

### Task 1: Database Migrations
**Files:**
- Modify: `database/migrations`

- [ ] **Step 1: Buat migrasi untuk tabel `rules`, `criterias`, `user_answers`, dan `prediction_results`**

```php
// Contoh migrasi untuk tabel rules
Schema::create('rules', function (Blueprint $table) {
    $table->id();
    $table->string('kode_rule');
    $table->string('deskripsi_rule');
    $table->decimal('mb', 3, 2);
    $table->decimal('md', 3, 2);
    $table->decimal('cf_pakar', 3, 2);
    $table->string('status_prediksi');
    $table->timestamps();
});
```

- [ ] **Step 2: Jalankan migrasi**

Run: `php artisan migrate`

---

### Task 2: Implementasi Logic Certainty Factor
**Files:**
- Create: `app/Services/CFEngineService.php`

- [ ] **Step 1: Implementasi logika CF pada `CFEngineService`**

```php
namespace App\Services;

class CFEngineService {
    public function calculate(array $userAnswers, array $rules) {
        $cfCombined = 0;
        foreach ($userAnswers as $answer) {
            $cfEvidence = $answer['cf_pakar'] * $answer['cf_user'];
            $cfCombined = $cfCombined + $cfEvidence * (1 - $cfCombined);
        }
        return $cfCombined;
    }
}
```

---

### Task 3: Controller & View
**Files:**
- Modify: `app/Http/Controllers/StudentController.php`
- Modify: `resources/views/prediksi.blade.php`

- [ ] **Step 1: Implementasikan method store untuk memproses prediksi**

```php
public function store(Request $request, CFEngineService $service) {
    // 1. Ambil data input
    // 2. Panggil $service->calculate(...)
    // 3. Simpan ke database
}
```

---
