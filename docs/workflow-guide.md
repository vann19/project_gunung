# Panduan Alur Kerja (Workflow) Laravel

Dokumentasi ini menjelaskan urutan standar (Standard Operating Procedure) dalam membuat fitur baru di Laravel, mulai dari Database hingga pengujian di Postman.

---

## 1. Database (Model & Migration)

Langkah pertama setiap membuat fitur yang menyimpan data adalah membuat tabel di Database.

### Perintah Artisan:
Gunakan flag `-m` untuk otomatis membuatkan Migration sekaligus dengan Model-nya.
```bash
php artisan make:model Product -m
```

### Mengedit Migration:
Buka file di folder `database/migrations/xxxx_create_products_table.php` dan tambahkan kolom:
```php
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 15, 2);
        $table->text('description')->nullable();
        $table->timestamps(); // otomatis buat created_at & updated_at
    });
}
```

### Jalankan Migration ke Database:
```bash
php artisan migrate
```

### Mengedit Model:
Buka file `app/Models/Product.php` dan izinkan kolom diisi secara massal (Mass Assignment):
```php
class Product extends Model
{
    protected $fillable = ['name', 'price', 'description'];
}
```

---

## 2. Membuat Controller

Controller berfungsi sebagai otak yang memproses data dari Model untuk dikirim ke View atau API.

### Perintah Artisan:
```bash
# Untuk tampilan web (Blade)
php artisan make:controller ProductController

# Untuk API (format JSON)
php artisan make:controller API/ProductApiController --api
```

### Contoh Isi Controller (Web):
```php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua data produk
        $products = Product::all();
        
        // Lempar data ke resources/views/products/index.blade.php
        return view('products.index', compact('products'));
    }
}
```

### Contoh Isi Controller (API) dengan ApiResponse Trait:
```php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponse;

class ProductApiController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $products = Product::all();
        // Menggunakan fungsi success() dari trait ApiResponse
        return $this->success($products, 'Data produk berhasil diambil');
    }
}
```

---

## 3. Mendaftarkan Route

Setelah Controller punya fungsi, kita harus daftarkan URL (Route) agar fungsi tersebut bisa diakses.

### Untuk Web (Tampilan Visual - Blade)
Buka `routes/web.php`:
```php
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);
```

### Untuk API (Untuk Mobile App / Frontend SPA)
Buka `routes/api.php`:
```php
use App\Http\Controllers\API\ProductApiController;

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductApiController::class, 'index']);
});
```

---

## 4. Menampilkan ke Views (Blade)

*(Lewati langkah ini jika kamu membuat API)*

Buat file baru di `resources/views/products/index.blade.php`:

```html
<x-layouts.app title="Daftar Produk">
    <div class="p-8">
        <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>
        
        <div class="grid grid-cols-3 gap-4">
            @foreach($products as $product)
                <x-card hover="true">
                    <h3 class="font-bold">{{ $product->name }}</h3>
                    <p class="text-green-600">Rp {{ number_format($product->price) }}</p>
                </x-card>
            @endforeach
        </div>
    </div>
</x-layouts.app>
```

---

## 5. Menggunakan Middleware (Keamanan/Proteksi)

Middleware bertugas sebagai "Satpam". Jika user belum login, dia tidak boleh mengakses halaman tertentu.

### Menerapkan Middleware di Route Web:
Gunakan `auth` untuk memaksa user login.
```php
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
```

### Menerapkan Middleware di Route API:
Gunakan `auth:sanctum` untuk memaksa user mengirimkan Token API.
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/create', [ProductApiController::class, 'store']);
    Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);
});
```

---

## 6. Cara Testing di Postman (Untuk API)

Postman digunakan untuk mengetes endpoint API tanpa perlu membuat frontend.

### A. Testing API Tanpa Login (Public)
1. Buka Postman.
2. Buat Request baru, pilih **GET**.
3. Masukkan URL: `http://127.0.0.1:8000/api/v1/ping`
4. Klik **Send**. Kamu akan melihat response JSON.

### B. Testing API yang Butuh Login (Auth Sanctum)

**Langkah 1: Dapatkan Token (Login)**
1. Buat Request baru, pilih **POST**.
2. Masukkan URL: `http://127.0.0.1:8000/api/v1/auth/login`
3. Ke tab **Body** -> pilih **raw** -> pilih format **JSON**.
4. Isi body:
   ```json
   {
       "email": "user@example.com",
       "password": "password123"
   }
   ```
5. Klik **Send**. Di response, kamu akan mendapatkan `access_token` yang panjang. Copy token tersebut.

**Langkah 2: Akses Endpoint yang Diproteksi Middleware**
1. Buat Request baru untuk mengakses route yang diproteksi (misal: GET `/api/v1/auth/profile`).
2. Masukkan URL: `http://127.0.0.1:8000/api/v1/auth/profile`
3. Pindah ke tab **Authorization**.
4. Di bagian Type, pilih **Bearer Token**.
5. Di kotak Token, paste token yang tadi kamu copy di Langkah 1.
6. Pindah ke tab **Headers** (opsional tapi disarankan). Tambahkan key: `Accept` dengan value: `application/json`.
7. Klik **Send**. Kamu akan bisa mengakses data yang terkunci tersebut!
