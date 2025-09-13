# Laporan Modul 1: Perkenalan Laravel
**Mata kuliah:** Workshop Web Lanjut
**Nama:** [Lediana Berasa]
**NIM:** [2024573010034]
**Kelas** [TI2C]

---

## Abstark
Laravel adalah framework PHP yang mempermudah pembuatan aplikasi web. Dengan konsep MVC, Laravel menyediakan fitur seperti routing, Blade template, dan Eloquent ORM untuk mengelola database. Framework ini membantu pengembang membuat aplikasi yang terstruktur, efisien, dan mudah dikembangkan.

---

## 1. Pendahuluan

Perkenalan Laravel
Laravel adalah sebuah framework PHP yang digunakan untuk membuat aplikasi web. Framework ini membantu programmer agar lebih mudah dalam mengatur kode, membuat tampilan, menghubungkan ke database, dan menambahkan fitur seperti login. Dengan Laravel, pembuatan aplikasi web menjadi lebih cepat, rapi, dan terstruktur.

Apa itu Laravel ?
Laravel adalah framework PHP yang digunakan untuk membuat aplikasi web.
Sederhananya, Laravel itu seperti “alat bantu” yang sudah menyediakan banyak fitur dasar, sehingga programmer tidak perlu menulis semuanya dari nol.

// Karakteristik Utama Laravel //

1. Arsitektur MVC (Model–View–Controller)
    Laravel menggunakan pola MVC untuk memisahkan logika aplikasi, tampilan, dan pengolahan data. Hal ini membuat kode lebih rapi, terstruktur, dan mudah dikelola.

2. Opinionated Framework
    Laravel dianggap opinionated karena sudah menyediakan “cara baku” dalam menulis kode (misalnya routing, struktur folder, migration). Programmer tinggal mengikuti standar ini agar lebih konsisten.

3. Eloquent ORM
    Laravel punya ORM bawaan bernama Eloquent yang memudahkan interaksi dengan database menggunakan sintaks PHP sederhana, tanpa perlu query SQL panjang.

4. Blade Templating Engine
    Untuk tampilan, Laravel menyediakan Blade yang ringan dan fleksibel, sehingga pembuatan UI lebih mudah dan cepat.

5. Routing yang Fleksibel
    Laravel punya sistem routing sederhana untuk mengatur URL dan aksi yang dituju. Bisa menggunakan route sederhana hingga resource route.

6. Fitur Modern & Siap Pakai
    Laravel sudah menyediakan banyak fitur bawaan seperti autentikasi, middleware, session, queue, cache, hingga integrasi API.

7. Ekosistem Lengkap
    Laravel punya banyak paket resmi (Breeze, Jetstream, Sanctum, Passport, Horizon, dll.) yang siap dipakai untuk memperluas kemampuan aplikasi.

8. Komunitas & Dokumentasi Kuat
    Laravel didukung oleh komunitas besar dan dokumentasi yang jelas, sehingga mudah dipelajari pemula maupun digunakan di proyek besar.

---

## 2. Komponen Utama Laravel (ringkas)

- Blade (templating)
    Alat untuk membuat tampilan web dengan kode yang rapi dan bisa memakai template agar tidak menulis ulang.
- Eloquent (ORM)
    Cara mudah mengelola database dengan model PHP tanpa harus menulis query SQL panjang.
- Routing
    Mengatur alamat URL dan menentukan apa yang ditampilkan saat URL diakses.
- Controllers
    Tempat menulis logika aplikasi, sebagai penghubung antara data (Model) dan tampilan (View).
- Migrations & Seeders
    Migration dipakai untuk membuat/ubah struktur tabel database, Seeder dipakai untuk isi data awal.
- Artisan CLI
    Perintah cepat di terminal untuk membuat file atau menjalankan fitur Laravel.
- Testing (PHPUnit)
    Digunakan untuk menguji aplikasi agar berjalan sesuai harapan dan bebas error.
- Middleware 
     Penjaga yang memeriksa request sebelum masuk ke aplikasi, misalnya cek login dulu.

---

## 3. Berikan penjelasan untuk setiap folder dan files yang ada didalam struktur sebuah project laravel.

1. Folder Utama

> app/
    Berisi kode utama aplikasi. Ada beberapa sub-folder:
        - Console/ → Perintah khusus untuk Artisan.
        - Exceptions/ → Mengatur error/pengecualian.
        - Http/ → Ada controller, middleware, dan request.
        - Models/ → Tempat membuat model (ORM Eloquent).
        - Providers/ → Service provider untuk mendaftarkan layanan Laravel.
> bootstrap/
        - Menyimpan file untuk mem-bootstrapping (memulai) aplikasi.
        - Ada app.php yang mengatur inisialisasi Laravel.
        - Folder cache/ untuk cache konfigurasi.
> config/
        - Semua pengaturan aplikasi Laravel (app.php, database.php, mail.php, dll).
        Bisa disesuaikan lewat .env.
> database/
        - migrations/ → File migrasi untuk membuat & mengubah tabel database.
        - seeders/ → Isi data awal otomatis.
        - factories/ → Membuat data dummy untuk testing.
> node_modules/
        - Berisi library JavaScript (otomatis dibuat oleh npm/yarn).
> public/
        - Folder yang diakses oleh browser.
        - Berisi index.php (pintu masuk aplikasi).
        - Asset seperti CSS, JS, gambar juga bisa ditempatkan di sini.
> resources/
        - views/ → File Blade (tampilan HTML).
        - lang/ → File bahasa untuk terjemahan.
        - css, js → File sumber daya front-end (diolah oleh Vite).
> routes/
        - web.php → Routing untuk halaman web.
        - api.php → Routing untuk API.
        - console.php → Routing untuk perintah Artisan.
        - channels.php → Routing untuk broadcasting event.
> storage/
        - app/ → File aplikasi.
        - framework/ → Cache, session, dan view yang dikompilasi.
        - logs/ → File log (laravel.log).
> tests/
        - Menyimpan file uji coba (testing).
        - Feature/ → Test fitur aplikasi.
        - Unit/ → Test unit kecil (misalnya fungsi)
> vendor/
        - Berisi semua library PHP dari Composer.
        - Jangan diubah manual.

2. File Utama

> .editorconfig → Aturan format kode (indentasi, spasi, dll).
> .env → File konfigurasi utama (database, mail, API key).
> .env.example → Contoh file .env.
> .gitattributes → Aturan khusus untuk Git (misalnya line ending).
> .gitignore → Menentukan file/folder yang diabaikan Git.
> artisan → Command-line tool Laravel (membuat model, controller, migrasi, dll).
> composer.json → Daftar dependency/library PHP yang dipakai Laravel.
> composer.lock → Versi detail dari dependency yang dipakai.
> package.json → Daftar dependency/library JavaScript (npm).
> package-lock.json → Versi detail library JavaScript.
> phpunit.xml → Konfigurasi untuk testing dengan PHPUnit.
> README.md → Dokumentasi dasar project.
> vite.config.js → Konfigurasi build asset (CSS, JS, dll).

---

## 4. Diagram MVC dan Cara kerjanya

> Letakkan gambar di dalam folder laporan1/gambar/diagrammvc. Kemudian masukkan gambar tersebut ke laporan. 

Metode inline, yaitu dengan menyebutkan secara langsung nama file yang akan dimasukkan dalam satu baris perintah.
- Memasukkan gambar tanpa teks titel. Teks titel adalah teks yang muncul jika mouse di tunjuk di atas gambar.        Secara umum sintax-nya adalah:

   ![Diagram MVC](./gambar/diagrammvc.png)

Cara Kerja MVC

1. Pengguna mengakses URL --> perminataan diirim ke Router laravel
2. Router memanggil Controller yang sesuai
3. Controller meminta/menyimpan datalewat Model
4. Controller mengirim data tersebut ke view
5. View menampilkan hasil ke Browser. 

---

## 6. Kelebihan & Kekurangan (refleksi singkat)
- Kelebihan Laravel menurut Saya

Kode lebih rapi dan terstruktur (pakai MVC).
Banyak fitur bawaan (auth, routing, template).
Dokumentasi lengkap & komunitas besar.

- Hal yang mungkin jadi tantangan bagi pemula

Instalasi awal cukup besar (Composer, npm).
Struktur folder yang banyak mungkin bikin bingung di awal.
Perlu paham dasar PHP OOP sebelum nyaman.

---

## 7. Referensi
Cantumkan sumber yang Anda baca (buku, artikel, dokumentasi) — minimal 2 sumber. Gunakan format sederhana (judul — URL).

- Laravel Documentation — https://laravel.com/docs
- Belajar Laravel untuk Pemula — https://www.petanikode.com/laravel/
- Tutorial Laravel (W3Schools) — https://www.w3schools.io/framework/laravel/

