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

# 📘 API Documentation

Dokumentasi ini mencakup seluruh endpoint dari sistem API yang tersedia, dibagi berdasarkan fungsionalitas utama.

---

## 1. 🔐 Autentikasi Pengguna

### **Login**

- **Method**: `POST`
- **URL**: `/auth/login`
- **Request Body**:

```json
{
  "username": "johndoe",
  "password": "123456"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Login berhasil",
  "data": {
    "user_id": 1,
    "username": "johndoe",
    "role_id": 2
  }
}
```

### **Register**

- **Method**: `POST`
- **URL**: `/auth/register`
- **Request Body**:

```json
{
  "username": "newuser",
  "password": "password123"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Register berhasil",
  "data": {
    "user_id": 5
  }
}
```

### **Kirim Data Personal Kasir**

- **Method**: `POST`
- **URL**: `/auth/personal-data`
- **Request Body**:

```json
{
  "user_id": 5,
  "gender": "Laki-laki",
  "tahun_masuk": 2023,
  "kelas": "12 IPA 1",
  "phone_number": "08123456789"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Data berhasil disimpan"
}
```

---

## 2. 👤 Manajemen Pengguna

### **Get All Users**

- **Method**: `GET`
- **URL**: `/users`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "user_id": 1,
      "username": "johndoe",
      "gender": "Laki-laki",
      "tahun_masuk": 2021,
      "kelas": "12 IPA",
      "role_id": 3,
      "status": "accepted",
      "is_active": "yes"
    }
  ]
}
```

### **Get Users Berdasarkan Role**

- **Pemilik**
  - **Method**: `GET`
  - **URL**: `/users/pemilik`
- **Admin**
  - **Method**: `GET`
  - **URL**: `/users/admin`
- **Kasir**
  - **Method**: `GET`
  - **URL**: `/users/kasir`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "user_id": 1,
      "username": "johndoe",
      "gender": "Laki-laki",
      "tahun_masuk": 2021,
      "kelas": "12 IPA",
      "role_id": 3,
      "status": "accepted",
      "is_active": "yes"
    }
  ]
}
```

### **Get User By ID**

- **Method**: `GET`
- **URL**: `/user/{user_id}`
- **Respone**:

```json
{
  "status": "success",
  "data": {
    "user_id": 1,
    "username": "johndoe",
    ...
  }
}

```

### **Create User**

- **Method**: `POST`
- **URL**: `/users`
- **Request Body**:

```json
{
  "username": "newuser",
  "password": "secret123",
  "gender": "Laki-laki",
  "tahun_masuk": 2024,
  "kelas": "11 IPA",
  "role_id": 3,
  "status": "pending",
  "is_active": "yes"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "User created successfully"
}
```

### **Update User**

- **Method**: `PUT`
- **URL**: `/user/{user_id}`
- **Request Body**:

```json
{
  "username": "updateduser",
  "password": "newpass123",
  "gender": "Perempuan",
  "tahun_masuk": 2023,
  "kelas": "12 IPS",
  "role_id": 2,
  "status": "accepted",
  "is_active": "yes"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "User updated successfully"
}
```

### **Delete User**

- **Method**: `DELETE`
- **URL**: `/user/{user_id}`
- **Respone**:

```json
{
  "status": "success",
  "message": "User deleted successfully"
}
```

---

## 3. 📦 Manajemen Produk

### **Get All Products**

- **Method**: `GET`
- **URL**: `/products`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "product_id": "B0000001",
      "product_name": "Rok",
      "category": "Ukuran: S / M / L / XL, Bahan: Bellini Savana",
      "description": "",
      "price": 100000.0,
      "stock_quantity": 10,
      "photo_url": null
    }
  ]
}
```

### **Get Product By ID**

- **Method**: `GET`
- **URL**: `/product/{product_id}`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "product_id": "B0000001",
      "product_name": "Rok",
      "category": "Ukuran: S / M / L / XL, Bahan: Bellini Savana",
      "description": "",
      "price": 100000.0,
      "stock_quantity": 10,
      "photo_url": null
    }
  ]
}
```

### **Get Product By Category**

- **Method**: `GET`
- **URL**: `/products/{category}`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "product_id": "B0000001",
      "product_name": "Rok",
      "category": "Ukuran: S / M / L / XL, Bahan: Bellini Savana",
      "description": "",
      "price": 100000.0,
      "stock_quantity": 10,
      "photo_url": null
    }
  ]
}
```

### **Create Product**

- **Method**: `POST`
- **URL**: `/products`
- **Request Body**:

```json
{
  "product_name": "Seragam Olahraga",
  "category": "Seragam",
  "description": "Ukuran: S / L / M / XL / XXL",
  "price": 200000,
  "stock_quantity": 100,
  "photo_url": null
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Product berhasil dibuat"
}
```

### **Update Product**

- **Method**: `PUT`
- **URL**: `/product/{product_id}`
- **Request Body**:

```json
{
  "product_name": "Seragam Olahraga",
  "category": "Seragam",
  "description": "Ukuran: S / L / M / XL / XXL",
  "price": 200000,
  "stock_quantity": 100,
  "photo_url": "https://example.com/image.jpg"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Product berhasil diperbarui"
}
```

### **Delete Product**

- **Method**: `DELETE`
- **URL**: `/product/{product_id}`
- **Request Body**:
- **Respone**:

```json
{
  "status": "success",
  "message": "Product berhasil dihapus"
}
```

---

## 4. 💸 Manajemen Diskon

### **Get All Discounts**

- **Method**: `GET`
- **URL**: `/discounts`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "discount_id": 1,
      "discount_name": "Diskon Akhir Tahun",
      "product_id" ; "B0000001",
      "product_type" ; "Bawahan",
      "discount_type" ; "percentage",
      "discount_percentage": 25,
      "flat_rate_discount": null,
      "status" ; "Private",
      "end_date" ; "30-04-20025",
      "created_at" ; ...time
    }
  ]
}

```

### **Create Discount**

- **Method**: `POST`
- **URL**: `/discounts`
- **Request Body**:

```json
{
  "discount_name": "Diskon Tahun Baru",
  "product_id": null,
  "product_type": "Aksesoris",
  "discount_type": "percentage",
  "discount_percentage": 10,
  "flat_rate_discount": null,
  "status": "Public",
  "end_date": "2025-12-31"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Discount berhasil dibuat"
}
```

### **Get Discount By ID**

- **Method**: `GET`
- **URL**: `/discount/{discount_id}`
- **Respone**:

```json
{
  "status": "success",
  "data": {
    "discount_id": "D123",
    "discount_name": "Diskon Spesial",
    ...
  }
}

```

### **Update Discount**

- **Method**: `PUT`
- **URL**: `/discount/{discount_id}`
- **Request Body**:

```json
{
  "discount_name": "Diskon Tahun Baru",
  "product_id": null,
  "product_type": "Aksesoris",
  "discount_type": "flat rate",
  "discount_percentage": null,
  "flat_rate_discount": 70000.0,
  "status": "Public",
  "end_date": "2025-12-31"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Discount berhasil diperbarui"
}
```

### **Delete Discount**

- **Method**: `DELETE`
- **URL**: `/discount/{discount_id}`
- **Respone**:

```json
{
  "status": "success",
  "message": "Discount berhasil dihapus"
}
```

---

## 5. 💳 Manajemen Transaksi

### **Get All Transactions**

- **Method**: `GET`
- **URL**: `/transactions`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "transaction_id": "T001",
      "user_id": 1,
      "total_amount": 1000000,
      "payment_method": "cash",
      "transaction_date": ...time
    }
  ]
}
```

### **Get Transaction By ID**

- **Method**: `GET`
- **URL**: `/transaction/{transaction_id}`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "transaction_id": "T001",
      "user_id": 1,
      "total_amount": 1000000,
      "payment_method": "cash",
      "transaction_date": ...time
    }
  ]
}
```

### **Create Transaction**

- **Method**: `POST`
- **URL**: `/transactions`
- **Request Body**:

```json
{
  "user_id": 1,
  "payment_method": "cash",
  "items": [
    {
      "product_id": "P001",
      "quantity": 2
    },
    {
      "product_id": "P002",
      "quantity": 1
    }
  ]
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Transaksi berhasil dibuat",
  "transaction_id": "T001"
}
```

### **Update Transaction**

- **Method**: `PUT`
- **URL**: `/transaction/{transaction_id}`
- **Request Body**:

```json
{
  "user_id": 2,
  "payment_method": "transfer"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Transaksi berhasil diperbarui"
}
```

### **Delete Transaction**

- **Method**: `DELETE`
- **URL**: `/transaction/{transaction_id}`

- **Respone**:

```json
{
  "status": "success",
  "message": "Transaksi berhasil dihapus"
}
```

---

## 6. 📥 Manajemen Restock

### **Get All Restocks**

- **Method**: `GET`
- **URL**: `/restocks`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "restock_id": "R001",
      "store_id": 10,
      "user_id": "3",
      "total_amount": 100000,
      "status": "pending",
      "restock_date": ...time,
      "notes": "Ini restock"
    }
  ]
}

```

### **Get Restock By ID**

- **Method**: `GET`
- **URL**: `/restock/{restock_id}`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "restock_id": "R001",
      "store_id": 10,
      "user_id": "3",
      "total_amount": 100000,
      "status": "pending",
      "restock_date": ...time,
      "notes": "Ini restock"
    }
  ]
}
```

### **Get Restocks by Status**

- **Method**: `GET`
- **URL**: `/restocks/{status}`
- **Respone**:

```json
{
  "status": "success",
  "data": [
    {
      "restock_id": "R001",
      "store_id": 10,
      "user_id": "3",
      "total_amount": 100000,
      "status": "pending",
      "restock_date": ...time,
      "notes": "Ini restock"
    }
  ]
}
```

### **Create Restock**

- **Method**: `POST`
- **URL**: `/restocks`
- **Request Body**:

```json
{
  "store_id": 1,
  "user_id": 3,
  "status": "pending",
  "notes": "pengajuan awal",
  "items": [
    {
      "product_id": "P001",
      "quantity": 10
    },
    {
      "product_id": "P002",
      "quantity": 5
    }
  ]
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Restock berhasil dibuat",
  "restock_id": "R001"
}
```

### **Update Restock Status**

- **Method**: `PUT`
- **URL**: `/restock/{restock_id}`
- **Request Body**:

```json
{
  "status": "approved"
}
```

- **Respone**:

```json
{
  "status": "success",
  "message": "Status restock berhasil diperbarui"
}
```

### **Delete Restock**

- **Method**: `DELETE`
- **URL**: `/restock/{restock_id}`
- **Respone**:

```json
{
  "status": "success",
  "message": "Restock berhasil dihapus"
}
```

---

🛠 **Note**: Pastikan untuk mengirim data dengan format dan headers yang sesuai pada setiap request, khususnya untuk metode `POST`, `PUT`, dan `DELETE`.

## Langkah Installasi

1. Clone repository ini menggunakan perintah `git clone https://github.com/JeaAP/Modapay-API.git`
2. Buat database dengan nama `modapay`
3. Atur konfigurasi database di file `config/database.php`
4. Jalankan perintah `php -S localhost:8080` untuk menjalankan server
5. Buka browser dan akses `http://localhost:8080` untuk melihat hasilnya
