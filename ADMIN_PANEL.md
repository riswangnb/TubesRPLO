# Admin Panel Documentation - FreshClean Laundry

## 📋 Daftar Lengkap

### Backend Setup ✅
- ✅ Models (Order, Pelanggan, Package) dengan relationships
- ✅ API Controllers (LaundryController, PelangganController, PackageController)
- ✅ API Routes (routes/api.php) - REST endpoints
- ✅ Database Migrations dengan foreign keys

### Admin Web Interface ✅

#### 1. **Layout & Navigation** 
- `resources/views/layouts/admin.blade.php` - Master layout dengan sidebar
  - Sidebar navigation dengan 4 menu utama
  - Header dengan notifikasi icon
  - Error/Success message display
  - Active route highlighting

#### 2. **Dashboard**
- `app/Http/Controllers/Admin/DashboardController.php`
- `resources/views/admin/dashboard.blade.php`
- Features:
  - Total Orders, Pelanggan, Packages cards
  - Total Revenue statistic
  - Recent Orders table dengan status badge
  - Status color coding (pending=yellow, proses=blue, selesai=green, diambil=gray)

#### 3. **Orders Management (CRUD)**
- Controller: `app/Http/Controllers/Admin/OrderController.php`
- Views:
  - `resources/views/admin/orders/index.blade.php` - List all orders
  - `resources/views/admin/orders/create.blade.php` - Create new order
  - `resources/views/admin/orders/edit.blade.php` - Edit order
- Features:
  - Auto price calculation: `total_harga = package.harga × berat`
  - Dropdown selection untuk Pelanggan & Package
  - Form validation dengan error messages
  - Pagination (10 items per page)
  - Delete dengan redirect

#### 4. **Packages Management (CRUD)**
- Controller: `app/Http/Controllers/Admin/PackageController.php`
- Views:
  - `resources/views/admin/packages/index.blade.php` - List packages
  - `resources/views/admin/packages/create.blade.php` - Create package
  - `resources/views/admin/packages/edit.blade.php` - Edit package
- Features:
  - Manage service packages (nama, harga, durasi_hari, deskripsi)
  - Price formatting dengan number_format
  - CRUD operations dengan validation

#### 5. **Pelanggan Management (CRUD)**
- Controller: `app/Http/Controllers/Admin/PelangganController.php`
- Views:
  - `resources/views/admin/pelanggans/index.blade.php` - List customers
  - `resources/views/admin/pelanggans/create.blade.php` - Add customer
  - `resources/views/admin/pelanggans/edit.blade.php` - Edit customer
- Features:
  - Customer data management (nama, telepon, email, alamat)
  - Phone number validation (max 20 chars)
  - Email validation (optional but must be valid if provided)
  - Full CRUD with pagination

---

## 🚀 Cara Menjalankan

### 1. Setup Environment
```bash
cd projectLaundry
composer install
php artisan migrate:fresh
```

### 2. Jalankan Server
```bash
php artisan serve
```

### 3. Akses Admin Panel
- Dashboard: http://localhost:8000/admin
- Orders: http://localhost:8000/admin/orders
- Packages: http://localhost:8000/admin/packages
- Pelanggan: http://localhost:8000/admin/pelanggans

---

## 📁 File Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── Admin/
│       │   ├── DashboardController.php
│       │   ├── OrderController.php
│       │   ├── PackageController.php
│       │   └── PelangganController.php
│       ├── LaundryController.php (API)
│       ├── PelangganController.php (API)
│       └── PackageController.php (API)
└── Models/
    ├── Order.php
    ├── Pelanggan.php
    ├── Package.php
    └── User.php

resources/views/
├── layouts/
│   └── admin.blade.php
└── admin/
    ├── dashboard.blade.php
    ├── orders/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── packages/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── pelanggans/
        ├── index.blade.php
        ├── create.blade.php
        └── edit.blade.php

routes/
├── api.php (REST API endpoints)
└── web.php (Admin web routes)
```

---

## 🔧 API Endpoints Reference

### Orders (API)
```
GET    /api/laundry           - Get all orders
POST   /api/laundry           - Create new order
GET    /api/laundry/{id}      - Get specific order
PUT    /api/laundry/{id}      - Update order
DELETE /api/laundry/{id}      - Delete order
```

### Pelanggan (API)
```
GET    /api/pelanggans        - Get all customers
POST   /api/pelanggans        - Create customer
GET    /api/pelanggans/{id}   - Get specific customer
PUT    /api/pelanggans/{id}   - Update customer
DELETE /api/pelanggans/{id}   - Delete customer
```

### Packages (API)
```
GET    /api/packages          - Get all packages
POST   /api/packages          - Create package
GET    /api/packages/{id}     - Get specific package
PUT    /api/packages/{id}     - Update package
DELETE /api/packages/{id}     - Delete package
```

---

## 💾 Database Schema

### orders table
```
id, pelanggan_id, package_id, tanggal_order, total_harga, berat, status, catatan
```

### pelanggans table
```
id, nama, alamat, telepon, email
```

### packages table
```
id, nama, deskripsi, harga, durasi_hari
```

---

## ✨ Features Highlight

1. **Auto Price Calculation** - Total harga otomatis dihitung dari harga package × berat
2. **Validation** - Semua form memiliki validasi server-side
3. **Error Handling** - Error messages ditampilkan dengan styling Tailwind
4. **Responsive Design** - Admin panel responsive dengan Tailwind CSS
5. **Status Management** - Order status dengan color coding
6. **Pagination** - List views dengan pagination 10 items/page
7. **CRUD Complete** - Full Create, Read, Update, Delete untuk semua entity

---

## 📝 Notes

- Admin panel belum memiliki authentication (bisa ditambahkan nanti)
- Styling menggunakan Tailwind CSS v3
- Icons dari Font Awesome v6.4.0
- Database migrations sudah ter-setup dengan foreign keys

---

**Status: ✅ SELESAI & SIAP DIGUNAKAN**
