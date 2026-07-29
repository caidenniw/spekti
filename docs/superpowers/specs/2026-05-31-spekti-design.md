---
name: spekti-design
description: Desain teknis sistem prediksi kelulusan mahasiswa 3,5 tahun dengan metode Certainty Factor.
metadata:
  type: project
---

# Desain Sistem SpekTi

## 1. Konteks
SpekTi adalah sistem pakar untuk memprediksi kelulusan mahasiswa dalam 3,5 tahun menggunakan metode Certainty Factor (CF). Sistem mengolah 8 variabel akademik dan non-akademik yang diinputkan mahasiswa beserta tingkat keyakinan (CF User).

## 2. Arsitektur & Komponen
- **Controller**: `StudentController` (HTTP Request handling)
- **Service Layer**: `CFEngineService` (Logika matematis CF, kombinasi evidence)
- **Model**:
  - `User`, `Criteria` (8 indikator), `Rule` (Knowledge Base), `PredictionResult` (Output)
- **Logika**:
  - `CF_Evidence` = `CF_Pakar` * `CF_User`
  - `CF_Combine` = `CF1` + `CF2` * (1 - `CF1`)

## 3. Data Flow
1. User login (NIM).
2. User input 8 kriteria + Skala keyakinan (CF User).
3. `CFEngineService` mengambil data `Rule` dari DB.
4. Perhitungan dilakukan di memori, hasil akhir disimpan di `prediction_results`.

## 4. Testing & Verifikasi
- Unit test untuk `CFEngineService` memastikan rumus `CF_Combine` akurat.
- Integrasi test untuk alur input kuesioner hingga penyimpanan hasil prediksi.
