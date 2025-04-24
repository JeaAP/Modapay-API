# ModaPay API

ModaPay API adalah **API** yang digunakan untuk menangani API pada aplikasi ModaPay. API ini dibangun menggunakan **PHP Native**, tanpa framework tambahan, dan akan terus berkembang sesuai kebutuhan. ModaPay API saat ini mencakup fitur untuk **login**, **registrasi**, **manajemen data pengguna**, serta **manajemen data product**.

## Fitur

- **Autentikasi Pengguna**: Pengguna dapat melakukan registrasi dan login.
- **Manajemen Pengguna**: Menyediakan endpoint untuk mengakses data pengguna.
- **Manajemen Product**: Menyediakan endpoint untuk mengakses data product.
- **Respons API dalam format JSON**.

## Teknologi

- PHP Native
- MySQL (untuk penyimpanan data)
- Password hashing menggunakan `PASSWORD_BCRYPT`

## Kumpulan URL Endpoint

### 1. **Autentikasi Pengguna**

#### **Login** (POST)

- **URL**: `/auth/login`

#### **Register** (POST)

- **URL**: `/auth/register`

### 2. **Manajemen Pengguna**

#### **Get All Users** (GET)

- **URL**: `/users`

#### **Create User** (POST)

- **URL**: `/users`

#### **Update User** (PUT)

- **URL**: `/user/{user_id}`

#### **Delete User** (DELETE)

- **URL**: `/user/{user_id}`

#### **Get User By ID** (GET)

- **URL**: `/user/{user_id}`

### 3. **Manajemen Product**

#### **Get All Products** (GET)

- **URL**: `/products`

#### **Create Product** (POST)

- **URL**: `/products`

#### **Update Product** (PUT)

- **URL**: `/product/{product_id}`

#### **Delete Product** (DELETE)

- **URL**: `/product/{product_id}`

#### **Get Product By ID** (GET)

- **URL**: `/product/{product_id}`

## Langkah Installasi

1. Clone repository ini menggunakan perintah `git clone https://github.com/JeaAP/Modapay-API.git`
2. Buat database dengan nama `modapay` dan hubungi kami untuk isi database
3. Atur konfigurasi database di file `config/database.php`
4. Jalankan perintah `php -S localhost:8080` untuk menjalankan server
5. Buka browser dan akses `http://localhost:8080` untuk melihat hasilnya