# ModaPay API

ModaPay API adalah **API** yang digunakan untuk menangani sistem otentikasi dan manajemen pengguna pada platform ModaPay. API ini dibangun menggunakan **PHP Native**, tanpa framework tambahan, dan akan terus berkembang sesuai kebutuhan. ModaPay API saat ini mencakup fitur untuk **login**, **registrasi**, serta **manajemen data pengguna**.

## Fitur

- **Autentikasi Pengguna**: Pengguna dapat melakukan registrasi dan login.
- **Manajemen Pengguna**: Menyediakan endpoint untuk mengakses data pengguna.
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

- **URL**: `/user`

#### **Create User** (POST)

- **URL**: `/users`

#### **Update User** (PUT)

- **URL**: `/user/{user_id}`

#### **Delete User** (DELETE)

- **URL**: `/user/{user_id}`

#### **Get User By ID** (GET)

- **URL**: `/user/{user_id}`
