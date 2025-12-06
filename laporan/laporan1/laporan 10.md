# Laporan Modul 9: Laravel JWT Authentication

**Mata Kuliah:** Workshop Web Lanjut   
**Nama:** [Lediana Berasa]  
**NIM:** [2024573010034]  
**Kelas:** [TI2C]  

---

## Abstrak 

Laporan praktikum ini membahas penerapan autentikasi berbasis token menggunakan JSON Web Token (JWT) dalam framework Laravel 12. Tujuan utamanya adalah untuk memahami konsep autentikasi stateless sebagai alternatif dari autentikasi berbasis sesi, yang sangat ideal untuk pengembangan API (Application Programming Interface). Metode yang digunakan dalam praktikum ini meliputi instalasi package `php-open-source-saver/jwt-auth`, konfigurasi model `User` untuk mendukung JWT, pembuatan middleware, dan pembuatan controller serta rute API untuk menangani proses registrasi, login, dan logout. Hasil praktikum menunjukkan pemahaman yang baik tentang alur kerja JWT dan kemampuan dalam membangun sistem autentikasi API yang aman, efisien, dan tidak menyimpan status (stateless).

---

## 1. Dasar Teori

### Apa itu JWT (JSON Web Token)?
JSON Web Token (JWT) adalah standar terbuka (RFC 7519) yang mendefinisikan cara untuk mentransfer informasi secara aman dan ringkas sebagai objek JSON. Informasi ini dapat diverifikasi dan dipercaya karena ditandatangani secara digital. JWT sering digunakan untuk autentikasi dan otorisasi dalam aplikasi web.

Sebuah JWT terdiri dari tiga bagian yang dipisahkan oleh titik (`.`):
1.  **Header:** Berisi metadata tentang token, seperti algoritma yang digunakan untuk menandatangani (misalnya, HS256) dan tipe token (JWT).
2.  **Payload:** Berisi klaim (claims), yaitu data tentang pengguna dan metadata tambahan. Klaim bisa berupa data standar (seperti `iss`/issuer, `exp`/expiration time) atau data kustom (seperti `name`, `email`).
3.  **Signature:** Digunakan untuk memverifikasi bahwa token tidak diubah selama transmisi. Signature dibuat dengan menggabungkan header yang di-encode, payload yang di-encode, sebuah rahasia (secret key), dan menandatanganinya dengan algoritma yang ditentukan di header.

### Alur Kerja Autentikasi JWT
Autentikasi JWT mengikuti alur yang berbeda dengan autentikasi berbasis sesi:
1.  **Login:** Pengguna mengirimkan kredensial (misalnya, email dan password) ke endpoint login di server.
2.  **Verifikasi:** Server memverifikasi kredensial pengguna terhadap database.
3.  **Penerbitan Token:** Jika kredensial valid, server membuat JWT yang berisi informasi pengguna (seperti ID dan peran) dan menandatanganinya dengan secret key. Server mengirimkan token ini kembali kepada klien.
4.  **Penyimpanan Token:** Klien menyimpan token ini (biasanya di localStorage atau sessionStorage).
5.  **Akses Resource Terlindungi:** Untuk setiap permintaan selanjutnya ke rute yang dilindungi, klien harus menyertakan JWT dalam header `Authorization` dengan format `Bearer <token>`.
6.  **Verifikasi Token:** Middleware di server akan mencegat permintaan, mengekstrak token, dan memverifikasi signature serta tanggal kedaluwarsanya. Jika token valid, permintaan diteruskan ke controller; jika tidak, server mengembalikan error `401 Unauthorized`.

### Keunggulan JWT (Stateless)
Keunggulan utama JWT adalah sifatnya yang **stateless**. Artinya, server tidak perlu menyimpan informasi sesi pengguna. Setiap permintaan membawa semua data yang diperlukan untuk autentikasi di dalam token itu sendiri. Ini memberikan beberapa keuntungan:
*   **Skalabilitas:** Karena server tidak perlu mengelola sesi, lebih mudah untuk melakukan skala horizontal (menambahkan lebih banyak server).
*   **Cocok untuk API dan SPA:** JWT sangat ideal untuk arsitektur API dan Single-Page Applications (seperti yang dibangun dengan React, Vue, atau Angular) di mana frontend dan backend terpisah.
*   **Decoupling:** Frontend dapat dikembangkan dan di-deploy secara terpisah dari backend.

### Perbandingan dengan Session-Based Auth
Autentikasi berbasis sesi (seperti yang digunakan oleh Laravel Breeze) bekerja dengan mencatat ID sesi di klien (cookie) dan menyimpan data sesi yang sesuai di server. Ini menciptakan "keadaan" (state) di server. Sementara itu, JWT menyimpan semua data di klien, membuat server stateless. Untuk aplikasi web tradisional dengan rendering di sisi server, sesi seringkali lebih sederhana. Untuk API modern, JWT adalah pilihan yang lebih umum.

---

## 2. Langkah-Langkah Praktikum

#### Langkah 1: Buat Project Laravel Baru
1.  Membuat proyek Laravel baru dengan perintah:
    ```
    laravel new laravel-jwt
    cd laravel-jwt
    code .
    ```
2.  Membuat database baru dengan nama `laravel_jwt` melalui phpMyAdmin.
3.  Mengkonfigurasi koneksi database di file `.env`:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_jwt
    DB_USERNAME=root
    DB_PASSWORD=
    ```
4.  Membersihkan konfigurasi cache:
    ```
    php artisan config:clear
    ```

#### Langkah 2: Instalasi Package JWT
1.  Menginstal package JWT yang diperlukan:
    ```
    composer require php-open-source-saver/jwt-auth
    ```

#### Langkah 3: Publish Konfigurasi JWT
1.  Mempublikasikan file konfigurasi package JWT ke dalam proyek:
    ```
    php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
    ```
    Perintah ini akan membuat file baru `config/jwt.php`.

#### Langkah 4: Generate Secret Key
1.  Menghasilkan secret key yang akan digunakan untuk menandatangani token:
    ```
    php artisan jwt:secret
    ```
    Perintah ini akan menambahkan variabel `JWT_SECRET` ke file `.env`.

#### Langkah 5: Modifikasi Model User
1.  Agar model `User` dapat menggunakan JWT, kita perlu mengimplementasikan interface `JWTSubject`. Buka file `app/Models/User.php` dan lakukan perubahan berikut:
    ```php
    <?php

    namespace App\Models;

    // Tambahkan use statement berikut
    use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable implements JWTSubject
    {
        use HasFactory, Notifiable;

        // ... kode lainnya ...

        /**
         * Get the identifier that will be stored in the subject claim of the JWT.
         *
         * @return mixed
         */
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }

        /**
         * Return a key value array, containing any custom claims to be added to the JWT.
         *
         * @return array
         */
        public function getJWTCustomClaims()
        {
            return [];
        }
    }
    ```

#### Langkah 6: Konfigurasi Middleware
1.  Untuk melindungi rute API, kita perlu mendaftarkan middleware `jwt.auth`. Buka file `bootstrap/app.php` dan tambahkan alias middleware di dalam `withMiddleware()`:
    ```php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'jwt.auth' => \PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate::class,
        ]);
    })
    ```

#### Langkah 7: Buat Rute Autentikasi API
1.  Buka file `routes/api.php` dan tambahkan rute untuk registrasi, login, dan logout:
    ```php
    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\AuthController;

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/profile', [AuthController::class, 'profile']);
    });
    ```
    *Catatan: `auth:api` adalah guard default yang menggunakan middleware `jwt.auth`.*

#### Langkah 8: Buat Controller Autentikasi
1.  Membuat controller untuk menangani logika autentikasi:
    ```
    php artisan make:controller Api/AuthController
    ```
2.  Buka file `app/Http/Controllers/Api/AuthController.php` dan tambahkan kode berikut:
    ```php
    <?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

    class AuthController extends Controller
    {
        public function register(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 201);
        }

        public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json([
                'token' => $token,
            ]);
        }

        public function profile()
        {
            return response()->json(auth('api')->user());
        }

        public function logout()
        {
            auth('api')->logout();
            return response()->json(['message' => 'Successfully logged out']);
        }
    }
    ```

#### Langkah 9: Uji Coba dengan Postman
1.  **Registrasi:**
    *   **Method:** `POST`
    *   **URL:** `http://localhost:8000/api/register`
    *   **Body:** `form-data` atau `raw JSON` dengan `name`, `email`, `password`.
    *   **Hasil:** Menerima response `201 Created` dengan data user dan token.
2.  **Login:**
    *   **Method:** `POST`
    *   **URL:** `http://localhost:8000/api/login`
    *   **Body:** `form-data` atau `raw JSON` dengan `email`, `password`.
    *   **Hasil:** Menerima response `200 OK` dengan token JWT.
3.  **Akses Profil (Tanpa Token):**
    *   **Method:** `GET`
    *   **URL:** `http://localhost:8000/api/profile`
    *   **Hasil:** Menerima response `401 Unauthorized`.
4.  **Akses Profil (Dengan Token):**
    *   **Method:** `GET`
    *   **URL:** `http://localhost:8000/api/profile`
    *   **Headers:** Tambahkan `Authorization: Bearer <token_yang_didapat_dari_login>`
    *   **Hasil:** Menerima response `200 OK` dengan data profil pengguna.
5.  **Logout:**
    *   **Method:** `POST`
    *   **URL:** `http://localhost:8000/api/logout`
    *   **Headers:** Tambahkan `Authorization: Bearer <token>`
    *   **Hasil:** Menerima response `200 OK` dengan pesan sukses.

---

## 3. Hasil dan Pembahasan

### Apakah aplikasi berjalan sesuai harapan?
Ya, aplikasi berjalan sesuai harapan. Semua endpoint API yang dibuat (`/register`, `/login`, `/profile`, `/logout`) berfungsi dengan benar. Proses registrasi berhasil membuat pengguna baru dan mengeluarkan token. Proses login berhasil memverifikasi kredensial dan memberikan token. Endpoint yang dilindungi (`/profile`) berhasil diakses ketika token yang valid disertakan dalam header dan menolak akses ketika token tidak ada atau tidak valid.

### Bagaimana JWT mengamankan API?
JWT mengamankan API dengan cara memastikan bahwa hanya pengguna yang memiliki token yang valid dan terverifikasi yang dapat mengakses rute yang dilindungi. Keamanan ini berasal dari:
1.  **Signature Digital:** Token ditandatangani menggunakan secret key yang hanya disimpan di server. Ini mencegah klien memodifikasi payload token (seperti mengubah peran user dari 'user' menjadi 'admin').
2.  **Kedaluwarsa (Expiration):** Token memiliki masa berlaku yang terbatas (didefinisikan di `config/jwt.php`). Ini membatasi jendela waktu jika token berhasil dicuri.
3.  **Transportasi yang Aman:** Meskipun token tidak dienkripsi, sebaiknya API berjalan melalui HTTPS untuk mencegah token diintersepsi (man-in-the-middle attack).

### Apa perbedaan utama antara menggunakan JWT dan Session (Breeze)?
Perbedaan utama terletak pada **state management**:
*   **Session (Breeze):** Server menyimpan status sesi pengguna di memori atau di tempat penyimpanan lain (file, database, Redis). Klien hanya menyimpan ID sesi di cookie. Ini membuat server "stateful".
*   **JWT:** Server tidak menyimpan apa pun. Semua informasi yang dibutuhkan untuk autentikasi ada di dalam token itu sendiri. Ini membuat server "stateless".

Karena perbedaan ini, JWT lebih cocok untuk arsitektur yang terdesentralisasi seperti API yang digunakan oleh berbagai klien (mobile app, web SPA), sementara sesi lebih sederhana untuk diterapkan pada aplikasi web monolitik tradisional.

### Apa fungsi masing-masing komponen (JWT Package, AuthController, Middleware jwt.auth)?
*   **JWT Package (`php-open-source-saver/jwt-auth`):** Menyediakan semua fungsionalitas inti untuk bekerja dengan JWT, seperti membuat token, mem-parsing token, memverifikasi signature, dan mengelola blacklist token (untuk logout).
*   **AuthController:** Bertindak sebagai otak dari logika bisnis autentikasi. Ia menangani permintaan dari klien, berinteraksi dengan model `User` untuk memverifikasi kredensial, dan menggunakan package JWT untuk membuat atau membatalkan token.
*   **Middleware `jwt.auth`:** Berfungsi sebagai penjaga gerbang (gatekeeper) untuk rute yang dilindungi. Ia secara otomatis memeriksa setiap permintaan yang masuk, mencoba mengidentifikasi pengguna dari token di header `Authorization`, dan jika gagal, akan menghentikan permintaan dan mengembalikan error `401 Unauthorized` sebelum mencapai controller.

---

## 4. Kesimpulan

Dari praktikum ini, saya berhasil memahami dan mengimplementasikan sistem autentikasi stateless menggunakan JWT di Laravel 12. Saya belajar bahwa JWT adalah solusi yang powerful dan efisien untuk mengamankan API, di mana server tidak perlu menyimpan status sesi, sehingga meningkatkan skalabilitas dan fleksibilitas. Proses instalasi package, konfigurasi model, pembuatan middleware, dan controller memberikan pemahaman end-to-end tentang cara kerja JWT. Pengujian dengan Postman memperkuat pemahaman tentang alur kerja token, dari penerbitan saat login hingga penggunaannya untuk mengakses resource terlindungi. Pengetahuan ini sangat penting untuk pengembangan aplikasi modern yang berbasis API dan single-page applications.

---

## 5. Referensi
1.  Tutorial LagiKoding - Laravel 12 JWT
    https://lagikoding.com/episode/tutorial-laravel-12-jwt
2.  Dokumentasi Resmi JWT (jwt.io)
    https://jwt.io/introduction
3.  Dokumentasi Package `php-open-source-saver/jwt-auth`
    https://github.com/PHP-Open-Source-Saver/jwt-auth
4.  Dokumentasi Resmi Laravel - API Authentication
    https://laravel.com/docs/sanctum