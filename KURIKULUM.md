# Kurikulum

Untuk menguasai Laravel secara menyeluruh (*mastering*) di tahun 2026, kurikulum yang ideal harus mencakup transisi dari dasar-dasar PHP modern hingga arsitektur *enterprise* dan ekosistem terbaru (seperti Laravel 11/12).

Berikut adalah draf kurikulum terstruktur yang dibagi menjadi 5 fase utama:

## Fase 1: Fondasi & PHP Modern

Sebelum menyentuh framework, Anda wajib memahami "mesin" di bawahnya.

* **Modern PHP:** PHP 8.x+ (Constructor Promotion, Readonly Properties, Enums).
* **OOP & SOLID:** Class, Interface, Abstract Class, dan prinsip SOLID agar kode tidak berantakan.
* **Composer:** Manajemen dependensi dan *autoloading*.
* **Database:** SQL Advanced, Normalisasi, dan indexing.

## Fase 2: Laravel Core (The Essentials)

Fase ini fokus pada bagaimana Laravel bekerja menangani *request*.

* **Request Lifecycle:** Memahami bagaimana Laravel memproses URL hingga menjadi tampilan.
* **Routing & Controllers:** Route groups, Middleware, dan Resource Controllers.
* **Blade Templating:** Layouting, Components, dan Directives.
* **Eloquent ORM Dasar:** Migrasi, Seeder, Factory, dan CRUD dasar.
* **Validation:** Form Requests dan custom validation rules.

---

## Fase 3: Intermediate - Logic & Security

Membangun fitur aplikasi yang nyata dan aman.

* **Eloquent Relationships:** One-to-One, One-to-Many, Many-to-Many, dan Polymorphic.
* **Authentication & Authorization:** Laravel Breeze/Jetstream, Gates, dan Policies.
* **API Development:** RESTful API, Laravel Sanctum, API Resources (Transforming data).
* **File Storage:** Local disk, AWS S3, dan Image Processing.
* **Automated Testing:** Unit & Feature Testing menggunakan **Pest** atau PHPUnit.

---

## Fase 4: Advanced - Scalability & Performance

Langkah menuju *Senior Developer* atau *Architect*.

* **Queues & Jobs:** Menangani proses berat di background (Redis, Horizon).
* **Caching:** Database caching (Redis/Memcached) dan Optimization.
* **Real-time Apps:** Laravel Reverb (WebSockets) dan Echo.
* **Design Patterns:** Repository Pattern, Service Layer, dan Action Classes.
* **Performance:** Eager Loading (mencegah N+1 query), Database Indexing, dan Laravel Octane.

---

## Fase 5: Ekosistem & Deployment (Modern Stack)

Menguasai alat pendukung yang membuat Laravel sangat kuat.

* **Frontend Monolith modern:** Livewire (TALL Stack) atau Inertia.js (VILT Stack).
* **Admin Panels:** **Filament PHP** (Sangat populer di 2025/2026 untuk membuat dashboard cepat).
* **DevOps:** Docker (Laravel Sail), Deployment via CI/CD (GitHub Actions), Laravel Forge, atau Laravel Cloud.

---

### Tips Belajar

Jangan hanya membaca dokumentasi. Cobalah membangun **satu proyek besar** secara bertahap (misalnya: *E-commerce* atau *HRIS System*) yang menerapkan semua poin di atas.

Apakah Anda ingin saya mendalami salah satu bagian spesifik, misalnya bagian **Advanced Architecture** atau **Filament PHP**?
