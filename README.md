<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🏥 Klinik App

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=flat-square">
  <img src="https://img.shields.io/badge/TailwindCSS-3.0-blue?style=flat-square">
  <img src="https://img.shields.io/badge/MySQL-Database-orange?style=flat-square">
  <img src="https://img.shields.io/badge/Status-Development-yellow?style=flat-square">
</p>

---

## 📌 Tentang Project

**Klinik App** adalah sistem manajemen klinik berbasis web yang dibangun menggunakan **Laravel 11** dan **Tailwind CSS**.

Aplikasi ini bertujuan untuk membantu digitalisasi proses administrasi klinik seperti:

- Pendataan pasien
- Manajemen dokter
- Penjadwalan janji temu
- Rekam medis pasien

---

## ✨ Fitur Utama

- 🔐 Autentikasi (Login & Register) menggunakan Laravel Breeze
- 👨‍⚕️ Manajemen Data Dokter (CRUD + Upload Foto)
- 🧑‍🤝‍🧑 Manajemen Data Pasien (CRUD + Upload Foto)
- 📅 Sistem Janji Temu (CRUD + Filter Status)
- 📄 Rekam Medis (Upload file PDF / Gambar)
- 📊 Dashboard dengan statistik real-time

---

## 🗄️ Struktur Database

| Tabel | Deskripsi |
|------|-----------|
| `users` | Data akun pengguna |
| `doctors` | Data dokter & spesialisasi |
| `patients` | Data pasien |
| `appointments` | Data janji temu |
| `medical_records` | Rekam medis pasien |

### 🔗 Relasi Tabel

- `Doctor` → hasMany `Appointments`
- `Patient` → hasMany `Appointments`
- `Appointment` → belongsTo `Doctor`, `Patient`
- `Appointment` → hasOne `MedicalRecord`
- `MedicalRecord` → belongsTo `Appointment`

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|------|-----------|
| Backend | Laravel 11 (PHP 8+) |
| Frontend | Blade + Tailwind CSS |
| Database | MySQL |
| Authentication | Laravel Breeze |
| Storage | Laravel Storage |

---

## ⚙️ Instalasi & Menjalankan Project

### 1. Clone Repository
```bash
git clone https://github.com/USERNAME/klinik-app.git
cd klinik-app
````

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Setup Environment

```bash
cp .env.example .env
```

### 5. Generate Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Edit file `.env`:

```env
DB_DATABASE=klinik_db
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `klinik_db` di phpMyAdmin.

---

### 7. Migration Database

```bash
php artisan migrate
```

### 8. Storage Link

```bash
php artisan storage:link
```

---

### 9. Jalankan Project

**Terminal 1**

```bash
php artisan serve
```

**Terminal 2**

```bash
npm run dev
```

---

### 10. Akses Aplikasi

```
http://localhost:8000
```

---

## 📁 Struktur Folder

```
klinik-app/
│
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── DoctorController.php
│   │   ├── PatientController.php
│   │   ├── AppointmentController.php
│   │   └── MedicalRecordController.php
│   │
│   └── Models/
│       ├── Doctor.php
│       ├── Patient.php
│       ├── Appointment.php
│       └── MedicalRecord.php
│
├── database/migrations/
├── resources/views/
│   ├── dashboard.blade.php
│   ├── doctors/
│   ├── patients/
│   ├── appointments/
│   └── medical-records/
│
├── routes/web.php
└── README.md
```

---

## 📸 Screenshot

> Tambahkan screenshot aplikasi di sini untuk mempercantik dokumentasi

Contoh:

* Dashboard
* Halaman Dokter
* Halaman Pasien

---

## 👨‍💻 Developer

| Nama                 | NIM       |
| -------------------- | --------- |
| Faiz Nur Badrieansya | 202432093 |

---

## 📄 Lisensi

Project ini dibuat untuk keperluan **tugas akademik** dan pembelajaran.



