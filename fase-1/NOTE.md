# Milestone 1: Data Architecture (Modern PHP & Enum)

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Task;
use App\Enums\TaskStatus;

$myTask = new Task(
    id: 1,
    title: "Belajar PHP Modern",
    description: "Memahami Enum dan Property Promotion",
    status: TaskStatus::IN_PROGRESS,
);

echo "Tugas: " . $myTask->title . PHP_EOL;
echo "Status: " . $myTask->status->getLabel() . PHP_EOL;

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

# Milestone 2: Repository Pattern

## Diskusi 1: Apa yang akan terjadi jika saya membuat class DatabaseRepository tapi lupa menuliskan method `save()`? Bagaimana PHP meresponnya?

Jika Anda membuat class `DatabaseRepository` yang mengimplementasikan `TaskRepositoryInterface` namun lupa (atau sengaja tidak) menuliskan method `save()`, PHP akan langsung memberikan respon berupa **Fatal Error**.

Berikut rincian apa yang akan terjadi:

### 1. Pesan Kesalahan (Fatal Error)
PHP tidak akan menjalankan kode aplikasi Anda sama sekali. Begitu script di-load (melalui autoloader), PHP akan mendeteksi pelanggaran "kontrak" tersebut dan menampilkan pesan kesalahan seperti ini:

> **Fatal error**: Class `App\Repositories\DatabaseRepository` contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (`App\Contracts\TaskRepositoryInterface::save`)

### 2. Mengapa Ini Terjadi?
Sesuai filosofi **Interface sebagai Kontrak**:
*   Saat Anda menulis `implements TaskRepositoryInterface`, Anda sedang "berjanji" kepada PHP bahwa class tersebut **pasti** memiliki semua method yang ada di file Interface.
*   PHP melakukan pengecekan ini pada tahap kompilasi (*compile-time*). Jika ada satu saja method yang hilang, PHP menganggap class tersebut "tidak lengkap" dan tidak valid untuk di-inisialisasi sebagai objek.

### 3. Solusi Jika Memang Belum Ingin Menulis Logikanya
Jika Anda sedang dalam proses coding dan ingin class tersebut tetap bisa di-load tanpa error meskipun isinya masih kosong, Anda harus setidaknya menuliskan "kerangka" method-nya:

```php
class DatabaseRepository implements TaskRepositoryInterface 
{
    public function save(Task $task): void 
    {
        // Biarkan kosong dulu, atau berikan placeholder
        throw new \Exception("Method save belum diimplementasikan");
    }

    public function getAll(): array 
    {
        return [];
    }
}
```

**Kesimpulan:**
PHP sangat tegas dalam hal ini. **Interface menjamin konsistensi**. Tanpa method `save()`, PHP menganggap `DatabaseRepository` merusak standarisasi yang sudah Anda tetapkan di Milestone 2 ini.

## Diskusi 2: Jelaskan konsep Polimorfisme pada fungsi `renderTasks(TaskRepositoryInterface $repository)`. Mengapa fungsi tersebut tetap bekerja meskipun nantinya saya mengganti `InMemoryTaskRepository` dengan `JsonTaskRepository`?

Konsep **Polimorfisme** pada fungsi `renderTasks` adalah alasan utama mengapa kode Anda menjadi sangat fleksibel dan mudah diatur. Berikut adalah penjelasan mendalamnya:

### 1. Arti Polimorfisme (Banyak Bentuk)
Dalam pemrograman berorientasi objek (OOP), polimorfisme memungkinkan satu interface (antarmuka) digunakan oleh berbagai tipe objek yang berbeda. 

Pada fungsi Anda:
```php
function renderTasks(TaskRepositoryInterface $repository): void
{
    $tasks = $repository->getAll();
    // ...
}
```
Parameter `$repository` memiliki tipe data `TaskRepositoryInterface`. Ini artinya, fungsi `renderTasks` **tidak peduli** class asli dari objek yang dimasukkan, asalkan objek tersebut "berwujud" (mengimplementasikan) `TaskRepositoryInterface`.

### 2. Mengapa Tetap Bekerja Saat Diganti?
Fungsi `renderTasks` tetap bekerja meskipun Anda mengganti `InMemoryTaskRepository` dengan `JsonTaskRepository` karena:

*   **Ketergantungan pada Kontrak, Bukan Implementasi:** Fungsi ini hanya bergantung pada "kontrak" (Interface). Kontrak tersebut menjamin bahwa method `getAll()` **pasti ada** dan **pasti mengembalikan array**, terlepas dari bagaimana cara data tersebut diambil (apakah dari memory, file JSON, atau database).
*   **Abstraksi:** `renderTasks` tidak perlu tahu detail teknis seperti `file_get_contents()` di JSON repository atau variabel `$tasks` di InMemory repository. Ia hanya perlu memanggil "tombol" `getAll()` yang sudah distandarisasi.

### 3. Analogi Sederhana
Bayangkan fungsi `renderTasks` adalah sebuah **Lampu Meja** dan `TaskRepositoryInterface` adalah **Stopkontak Standar**:
*   `InMemoryTaskRepository` adalah **Baterai**.
*   `JsonTaskRepository` adalah **Listrik PLN**.

Lampu meja Anda akan tetap menyala selama ia dicolokkan ke stopkontak yang standar. Lampu tersebut tidak peduli dari mana sumber energinya berasal (Baterai atau PLN), selama tegangan dan bentuk colokannya sama (yaitu method `getAll()` dan `save()`).

### 4. Keuntungan Utama (Decoupling)
Dengan polimorfisme ini, Anda mendapatkan manfaat **Decoupling** (keterlepasan):
1.  **Pluggable:** Anda bisa menambah `DatabaseTaskRepository` atau `ApiTaskRepository` di masa depan tanpa mengubah satu baris pun kode di dalam fungsi `renderTasks`.
2.  **Ease of Testing:** Anda bisa memasukkan "Repository Palsu" (Mock) saat melakukan testing tanpa harus benar-benar membaca file JSON asli.

---

**Kesimpulan:**
Fungsi `renderTasks` tetap bekerja karena ia percaya pada **Interface**. Selama Anda memberikan objek yang mengimplementasikan interface tersebut, PHP menjamin bahwa method yang dibutuhkan tersedia, sehingga logika internal fungsi tidak perlu berubah. Ini adalah inti dari prinsip **Open/Closed Principle** (Terbuka untuk pengembangan, Tertutup untuk modifikasi).

## Diskusi 3: Kenapa di Laravel kita sering melihat pola seperti ini (Interface dan Repository)?

Pola **Interface + Repository** sangat populer di ekosistem Laravel karena pola ini sejalan dengan filosofi Laravel yang mengutamakan fleksibilitas dan kemudahan testing. 

Berikut adalah alasan utamanya:

### 1. Prinsip Dependency Inversion (S dari SOLID)
Prinsip ini menyatakan bahwa kode level tinggi (seperti Controller atau Service) tidak boleh bergantung langsung pada kode level rendah (seperti Eloquent atau Query Database). Keduanya harus bergantung pada **Abstraksi** (Interface).
*   **Tanpa Repository:** Controller Anda "terkunci" dengan Eloquent. Jika Anda ingin pindah ke database NoSQL atau API pihak ketiga, Anda harus membongkar Controller.
*   **Dengan Repository:** Controller hanya tahu cara memanggil `taskRepository->all()`. Ia tidak peduli apakah di dalamnya menggunakan Eloquent, Raw SQL, atau Memcached.

### 2. Kekuatan Service Container Laravel
Laravel memiliki fitur **Dependency Injection** yang sangat kuat. Anda bisa melakukan "Binding" di `AppServiceProvider`:

```php
// Di AppServiceProvider.php
$this->app->bind(TaskRepositoryInterface::class, JsonTaskRepository::class);
```

Dengan satu baris kode di atas, Laravel akan otomatis menyuntikkan `JsonTaskRepository` ke setiap Controller yang me-request `TaskRepositoryInterface`. Jika bulan depan Anda ingin pindah ke Database, Anda **cukup mengubah satu baris** di Service Provider tersebut menjadi:

```php
$this->app->bind(TaskRepositoryInterface::class, DatabaseTaskRepository::class);
```
Dan boom! Seluruh aplikasi Anda langsung menggunakan database tanpa mengubah satu pun baris kode di Controller.

### 3. Kemudahan Testing (Mocking)
Saat menulis *Unit Test*, kita sering tidak ingin benar-benar menyentuh database agar test berjalan cepat.
*   Dengan Interface, Anda bisa membuat "Repository Palsu" (*Mocking*) yang hanya mengembalikan array statis. 
*   Anda bisa mengetes logika Controller tanpa perlu melakukan setup database atau file JSON yang rumit.

### 4. Menghindari Fat Controller
Tanpa Repository, seringkali logika query yang kompleks (seperti filter, sorting, join) menumpuk di Controller. 
*   Repository bertugas sebagai **Layer Abstraksi Data**. Controller cukup meminta "tolong ambilkan tugas yang belum selesai", dan Repository yang menangani kerumitan query-nya.
*   Ini membuat Controller Anda tetap bersih (*Slim Controller*) dan hanya fokus mengatur alur HTTP request/response.

### 5. Arsitektur yang "Future-Proof"
Dunia software berubah cepat. Penggunaan Interface memproteksi logika bisnis utama Anda dari perubahan infrastruktur. Kontrak yang Anda buat di Milestone 2 ini memastikan bahwa core logic aplikasi Anda tetap aman meskipun tim IT memutuskan mengganti server atau jenis database di masa depan.

---

**Kesimpulan sederhana:**
Di Laravel, kita menggunakan pola ini bukan untuk "mempersulit diri dengan banyak file", tapi untuk membangun **sistem yang plug-and-play**. Interface adalah kabel standarnya, dan Repository adalah perangkat yang bisa kita bongkar pasang dengan mudah.