```
Viewed app.php:1-22
Listed directory Models
Viewed Task.php:1-16
```

Penggunaan `readonly class` pada model `Task` memberikan beberapa manfaat signifikan dalam konteks **keamanan dan integritas data**:

### 1. Immutability (Data tidak dapat diubah)
Manfaat utama adalah **immutability**. Sekali objek `Task` dibuat, nilainya tidak dapat diubah dari mana pun dalam aplikasi.
*   **Keamanan:** Ini mencegah bug di mana data secara tidak sengaja diubah oleh fungsi atau method di tengah alur logika bisnis (misalnya di dalam loop atau service lain).
*   **Contoh:** Jika Anda mencoba melakukan `$myTask->status = TaskStatus::COMPLETED;` setelah objek dibuat, PHP akan melempar `Error`.

### 2. Mencegah "Side Effects"
Dalam aplikasi besar, seringkali sebuah objek dilewatkan (*passed by reference*) ke berbagai fungsi. Tanpa `readonly`, salah satu fungsi tersebut mungkin mengubah properti objek tanpa disadari oleh bagian kode yang lain.
*   **Keamanan:** Anda mendapatkan jaminan bahwa state objek akan tetap sama sepanjang masa hidupnya (*lifecycle*) dalam satu request. Ini membuat kode lebih mudah diprediksi (*predictable*).

### 3. Integritas State (Value Objects)
`readonly class` memaksa model Anda berperilaku sebagai *Value Object*.
*   **Keamanan:** Jika Anda ingin mengubah data `Task`, Anda dipaksa untuk membuat instance baru (misal dengan pola `clone` atau method manual). Ini memastikan bahwa perubahan data dilakukan secara eksplisit dan terkontrol, bukan modifikasi di tempat (*in-place mutation*) yang berisiko.

### 4. Pencegahan Manipulasi Properti Tak Terduga
Karena semua properti dalam `readonly class` secara otomatis menjadi `readonly`, tidak ada celah bagi developer lain (atau script pihak ketiga) untuk menyisipkan data atau mengubah ID tugas secara ilegal setelah proses validasi di awal (saat `__construct`) selesai.

---

**Ringkasan untuk Model Anda:**
Dengan struktur:
```php
readonly class Task {
    public function __construct(
        public int $id,
        public string $title,
        ...
    ) {}
}
```
Anda memastikan bahwa `id` dan `title` yang sudah divalidasi saat pembuatan objek tidak akan pernah bisa dimanipulasi di titik mana pun setelahnya, memberikan lapisan perlindungan ekstra terhadap kerusakan status data aplikasi.