# SYLLABUS: FONDASI & PHP MODERN

Fase 1 adalah pondasi krusial. Tanpa pemahaman PHP yang kuat, Anda hanya akan menjadi "Copy-Paste Developer" di Laravel. Berikut adalah rincian mendalam untuk Fase 1:

Dalam **Project-Based Learning (PjBL)**, kurikulum tidak lagi diajarkan sebagai teori terpisah, melainkan sebagai tantangan teknis yang muncul saat membangun sebuah produk.

Di Fase 1 ini, proyek utama Anda adalah membangun **"The Core Engine: Backend Task Orchestrator"**. Ini adalah aplikasi CLI (Command Line Interface) yang mensimulasikan bagaimana sebuah framework (seperti Laravel) mengelola data dan logika.

---

## Proyek Utama: Backend Task Orchestrator

**Deskripsi:** Sebuah aplikasi pengelola tugas yang mendukung berbagai media penyimpanan (File/Database), sistem otentikasi sederhana, dan manajemen status yang ketat menggunakan standar PHP Modern.

### 1. Silabus Berbasis Milestone (PjBL)

Silabus ini disusun berdasarkan urutan fitur yang akan Anda bangun:

* **Milestone 1: Arsitektur Data (Modern PHP & Enums)**
  * Membuat struktur data tugas menggunakan `Readonly Properties`.
  * Mengelola status (Pending, On Progress, Completed) menggunakan `Enums`.
  * Menggunakan `Match Expression` untuk logika alur status.
* **Milestone 2: Kontrak & Fleksibilitas (Interfaces & Abstract Classes)**
  * Membuat `StorageInterface` untuk mendefinisikan cara simpan/ambil data.
  * Implementasi `JsonStorage` dan `ArrayStorage` (Polimorfisme).
  * Memahami kenapa Laravel bisa mendukung berbagai database (MySQL, PostgreSQL) dengan prinsip ini.
* **Milestone 3: Pengorganisasian Kode (Namespaces & PSR-4)**
  * Mengatur struktur folder mengikuti standar industri (`src/`, `tests/`).
  * Konfigurasi `composer.json` untuk *autoloading* class secara otomatis.
* **Milestone 4: Manajemen Dependensi (Composer)**
  * Mengintegrasikan library `Carbon` untuk manipulasi waktu tugas.
  * Mengintegrasikan library `Termwind` (dari ekosistem Laravel) untuk mempercantik tampilan CLI.
* **Milestone 5: Error Handling & Type Safety**
  * Menerapkan `strict_types=1`.
  * Membuat *Custom Exception* untuk menangani tugas yang tidak ditemukan.

---

### 2. Capaian (Learning Outcomes)

Melalui proyek ini, Anda akan mencapai kompetensi:

1. **Code Scalability:** Mampu membuat sistem yang mudah diganti komponennya (misal: ganti cara simpan data) tanpa merusak seluruh kode.
2. **Modern Syntax Mastery:** Terbiasa menggunakan fitur PHP 8.2+ yang membuat kode lebih ringkas dan minim error.
3. **Framework Readiness:** Memahami konsep *Dependency Injection* dan *Service Provider* secara alami sebelum menemukannya di Laravel.

---

### 3. Ujian Akhir Proyek (Final Submission)

Ujian Anda bukan menjawab soal, melainkan melakukan **Refactoring & Feature Expansion**:

* **Tugas 1 (Refactor):** Ubah semua constructor lama di proyek Anda menjadi `Constructor Property Promotion`.
* **Tugas 2 (Expansion):** Tambahkan fitur "Log Logger". Setiap kali tugas dibuat, sistem harus mencatat log. Gunakan `Trait` untuk fungsi logging ini agar bisa dipakai di berbagai Class.
* **Tugas 3 (Testing):** Buat satu file tes sederhana (tanpa framework testing dulu) untuk memastikan fungsi `StorageInterface` berjalan sesuai kontraknya.

---

### Matriks Konsistensi Kurikulum PjBL

| Kriteria | Implementasi dalam Proyek |
| :--- | :--- |
| **Sistematis** | Dimulai dari struktur data (Internal) ke manajemen paket (External). |
| **Fleksibel** | Anda bisa memilih menyimpan data di file `.txt`, `.json`, atau `SQLite`. |
| **Aktual** | Menggunakan library `Termwind` yang merupakan standar UI CLI Laravel modern. |
| **Menyeluruh** | Menggabungkan logika murni, manipulasi file, dan manajemen library. |

---

### Langkah Pertama Anda

Buatlah folder proyek dan file `composer.json`. Definisikan `namespace` untuk aplikasi Anda (misal: `App\Core`).
