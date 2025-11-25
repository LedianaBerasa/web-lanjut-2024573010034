# **Laporan Proyek: Implementasi RESTful API untuk Manajemen Produk dengan Laravel 12**

**Mata Kuliah:** *Isi sesuai kebutuhan*
**Nama:** *Isi nama Anda*
**NIM:** *Isi NIM Anda*
**Kelas:** *Isi kelas Anda*

---

## **Abstrak**

Proyek ini bertujuan untuk membangun RESTful API yang dapat melakukan operasi CRUD (Create, Read, Update, Delete) pada data produk. API dikembangkan menggunakan *Laravel 12* dengan memanfaatkan fitur modern seperti Laravel Resource untuk transformasi data dan Laravel Form Request untuk validasi input. Implementasi ini memberikan API yang efisien, rapi, terstruktur, serta memastikan data tervalidasi dengan baik sebelum diproses oleh sistem.

---

## **Dasar Teori**

### **RESTful API**

RESTful API adalah gaya arsitektur layanan web yang memanfaatkan prinsip *stateless*, di mana setiap permintaan yang masuk ke server tidak menyimpan status sebelumnya. Data diakses melalui *resource* dan menggunakan metode HTTP seperti:

* **GET** → mengambil data
* **POST** → menyimpan data baru
* **PUT/PATCH** → memperbarui data
* **DELETE** → menghapus data

REST memfokuskan pada struktur endpoint yang konsisten dan penggunaan representasi resource yang jelas.

---

### **Peran Laravel Resource**

Laravel Resource (seperti **ProductResource**) digunakan untuk memformat data sebelum dikirim ke client. Fungsinya antara lain:

* Menyembunyikan field yang tidak diperlukan atau sensitif
* Menstandarkan format respons API
* Memudahkan pemeliharaan karena struktur output terpusat
* Menghasilkan output JSON yang rapi dan konsisten

Dengan Resource, data yang dikirimkan ke pengguna lebih terorganisir dan mudah dikelola.

---

### **Peran Laravel Request**

**Form Request (ProductRequest)** berfungsi sebagai validator yang dijalankan sebelum data diproses. Manfaatnya:

* Memvalidasi input secara otomatis
* Menolak data yang tidak valid secara konsisten
* Mencegah error pada database
* Membersihkan controller agar fokus pada logika bisnis
* Mengatur otorisasi dan validasi pada satu tempat

Dengan Form Request, API menjadi lebih aman dan terstruktur.

---

### **Konsep CRUD pada API**

CRUD adalah operasi dasar manajemen data:

| Operasi CRUD | Metode HTTP | Fungsi                           |
| ------------ | ----------- | -------------------------------- |
| Create       | POST        | Menambahkan data produk          |
| Read         | GET         | Mengambil satu atau semua produk |
| Update       | PUT/PATCH   | Memperbarui data produk          |
| Delete       | DELETE      | Menghapus produk                 |

Pada Laravel, operasi CRUD tersebut diatur melalui controller sesuai standar RESTful.

---

## **Langkah-Langkah Implementasi**

### **4.1 Persiapan Proyek dan Database**

Langkah persiapan proyek setelah melakukan clone dari GitHub:

1. Masuk ke folder proyek
2. Instal dependensi:

```
composer install
```

3. Salin file `.env.example` menjadi `.env`
4. Atur koneksi database di file `.env`
5. Generate application key:

```
php artisan key:generate
```

6. Jalankan migrasi untuk membuat tabel:

```
php artisan migrate
```

7. Jalankan server Laravel:

```
php artisan serve
```

---

### **4.2 Implementasi Komponen Inti**

#### **Model dan Migrasi Produk**

```bash
php artisan make:model Product -m
```

#### **Controller Produk**

```bash
php artisan make:controller ProductController
```

#### **Form Request Produk**

```bash
php artisan make:request ProductRequest
```

#### **Resource Produk**

```bash
php artisan make:resource ProductResource
```

---

### **4.3 Definisi Endpoint API**

Berikut definisi routing API untuk CRUD produk yang ditulis dalam file `routes/api.php`:

```php
Route::apiResource('products', ProductController::class);
```

Endpoint yang dihasilkan:

* **GET /api/products** → mengambil semua produk
* **GET /api/products/{id}** → mengambil produk tertentu
* **POST /api/products** → membuat produk baru
* **PUT /api/products/{id}** → memperbarui produk
* **DELETE /api/products/{id}** → menghapus produk

---

## **Hasil dan Pembahasan**

### **Contoh Respons GET (Menggunakan ProductResource)**

```json
{
    "status": true,
    "message": "Products retrieved successfully",
    "data": [
        {
            "id": 4,
            "name": "Laptop",
            "price": "15000000.00",
            "description": "Laptop gaming terbaru",
            "stock": 10,
            "created_at": "2025-11-24 05:35:58"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 10,
        "total": 4
    }
}
```

**Penjelasan:**
Laravel Resource memastikan bahwa setiap respons dari API memiliki struktur yang konsisten, mulai dari `status`, `message`, hingga format data. Keseragaman ini memudahkan integrasi API dengan frontend atau aplikasi pihak ketiga.

---

### **Bagaimana ProductRequest Mencegah Data Invalid**

Saat melakukan POST atau PUT, Form Request otomatis memvalidasi data yang masuk:

* Name wajib diisi
* Price harus numerik
* Stock harus angka
* Description harus string

Jika data tidak sesuai aturan, API mengembalikan kesalahan validasi tanpa melanjutkan proses ke database.

Ini memastikan:

* Data tetap bersih
* Kesalahan manusia dapat dicegah
* API menjadi lebih aman

---

### **Pembahasan: Manfaat Penggunaan Resource & Form Request**

* **Laravel Resource** memberikan format respons yang konsisten
* **Form Request** mencegah input sembarangan
* Controller menjadi lebih sederhana dan mudah dikelola
* Aplikasi lebih mudah dikembangkan dan diperluas
* API lebih aman karena semua validasi dilakukan di satu tempat

Kombinasi kedua fitur ini membuat API lebih *maintainable* dan profesional.

---

## **Kesimpulan**

Proyek ini berhasil mengimplementasikan RESTful API CRUD menggunakan Laravel 12 dengan memanfaatkan fitur Laravel Resource dan Form Request untuk validasi dan transformasi data. API yang dihasilkan mengikuti standar REST, memiliki struktur respons yang konsisten, serta menjaga keamanan dan kualitas data. Implementasi ini dapat dijadikan dasar untuk pengembangan aplikasi API yang lebih kompleks dan skalabel.

---

## **Referensi**

* Tutorial Laravel 12 RESTful API – LagiKoding
  [https://lagikoding.com/episode/tutorial-laravel-12-restful-api-9-download-source-code](https://lagikoding.com/episode/tutorial-laravel-12-restful-api-9-download-source-code)
