# Sistem Pendukung Keputusan Pemilihan Konsultan Sertifikasi Halal

**Platform Terintegrasi PROMETHEE II untuk Manajemen Jasa Konsultasi Halal**

---

## 📋 Overview

Sistem Informasi Pengelolaan Jasa Konsultan Halal dengan Sistem Pendukung Keputusan (SPK) berbasis metode **PROMETHEE II** yang terintegrasi dengan analisis spasial **Haversine Distance**. Platform ini menyediakan rekomendasi otomatis penugasan konsultan halal kepada klien berdasarkan multi-kriteria dengan mempertimbangkan faktor:

- **Kecocokan Spesialisasi Industri** (Kriteria Kualitatif)
- **Pengalaman & Sertifikasi** (Riwayat Evaluasi)
- **Jarak Geografis Lokasi Audit** (Formula Haversine)
- **Reputasi Historis** (Performa Sebelumnya)
- **Ketersediaan & Kompetensi** (Data Dinamis)

Solusi ini dikhususkan untuk **Lembaga Sertifikasi Halal** dalam memfasilitasi pencocokan optimal antara klien dan konsultan pendamping sertifikasi halal.

---

## 🎯 Problem Statement

**Tantangan Bisnis:**
1. Penugasan konsultan dilakukan secara manual dan subjektif tanpa standar objektif
2. Tidak ada pertimbangan sistematik terhadap kecocokan spesialisasi industri klien
3. Faktor jarak geografis tidak dioptimalkan dalam pemilihan konsultan
4. Belum ada mekanisme penilaian historis konsultan untuk keputusan masa depan
5. Proses pengajuan, verifikasi, dan pembayaran masih terpisah-pisah

---

## ✨ Features

### 🔐 **1. Multi-Role Authentication & Authorization**
- **Admin** → Pengelolaan master data, konfigurasi kriteria SPK, plotting konsultan
- **Klien** → Pengajuan proyek, tracking status, pembayaran, dokumen
- **Konsultan** → Dashboard penugasan, jadwal audit, validasi dokumen, laporan
- **Keuangan** → Invoice, monitoring pembayaran (termin), laporan keuangan
- Implementasi: **Laravel Breeze** + Custom Middleware Role-Based

### 📊 **2. Sistem Pendukung Keputusan PROMETHEE II**
- **Multi-Kriteria Ranking**: Penempatan 6 tipe fungsi preferensi (Usual, U-Shape, V-Shape, Level, Linear, Gaussian)
- **Pairwise Comparison**: Komparasi berpasangan antar konsultan
- **Flow Calculation**: 
  - Leaving Flow (Φ⁺) → Kekuatan alternatif
  - Entering Flow (Φ⁻) → Kelemahan alternatif
  - Net Flow (Φ) → Perangkingan final
- **Fuzzy Parameter**: Support parameter P, Q, S untuk preference function threshold

### 🗺️ **3. Integrasi Haversine Distance Calculation**
- Perhitungan jarak geodesi real-world antar lokasi
- Formula akurat untuk radius Bumi 6371 km
- Automatic geo-location consideration dalam kriteria C4
- Mendukung tracking lokasi klien dan domisili konsultan

### 💼 **4. Manajemen Proyek Terintegrasi**
- **Pengajuan Klien**: Form intake lengkap dengan validasi profil perusahaan
- **Project Tracking**: Timeline dari intake → rekomendasi → penugasan → audit → sertifikat
- **Document Management**: Upload persyaratan, validasi dokumen oleh konsultan
- **Certificate Issuance**: Admin upload sertifikat halal final

### 💳 **5. Payment Gateway Integration (Midtrans)**
- Two-tier payment system:
  - **Termin 1**: 60% setelah penugasan konsultan
  - **Termin 2**: 40% setelah audit selesai
- Webhook listener untuk real-time payment confirmation
- Invoice generation otomatis oleh departemen keuangan
- Payment tracking & PDF export untuk audit

### 📈 **6. Pelaporan & Analytics**
- Dashboard real-time untuk setiap role
- Finance Reports: Revenue, payment status, outstanding invoices
- Consultant Performance: Assignment count, audit completion rate
- Client Status: Certification progress tracker
- Export PDF & data analytics

---

## 🔬 PROMETHEE II Implementation

### **Algoritma Inti**

```
INPUT: Matriks Keputusan (m alternatif × n kriteria)
        + Bobot Kriteria (Σ bobot = 1)
        + Tipe Fungsi Preferensi per Kriteria

STEP 1: Normalisasi & Perhitungan Nilai Kriteria
   ├─ C1 (Spesialisasi): Matching string kategori
   ├─ C2-C3, C5-C6 (Evaluasi): Ambil nilai dari ConsultantEvaluation
   └─ C4 (Jarak): Haversine Distance formula

STEP 2: Pairwise Preference Calculation (a, b ∈ Alternatif)
   For setiap pasang alternatif (a,b):
   ├─ Hitung deviasi per kriteria: d = nilai_a - nilai_b (atau sebaliknya)
   ├─ Aplikasikan fungsi preferensi: P(d, kriteria)
   └─ Agregasi weighted: Σ(P_i × w_i) / Σ(w_i)

STEP 3: Flow Calculation
   ├─ Φ⁺(a) = Σ π(a,b) / (n-1)  [Leaving Flow]
   ├─ Φ⁻(a) = Σ π(b,a) / (n-1)  [Entering Flow]
   └─ Φ(a) = Φ⁺(a) - Φ⁻(a)      [Net Flow] → Ranking

OUTPUT: Sorted list konsultan by Φ (descending)
```

### **Criteria Definition**

| Kode | Nama | Tipe | Tren | Fungsi Preferensi | Bobot | Parameter |
|------|------|------|------|-------------------|-------|-----------|
| C1 | Kecocokan Spesialisasi | Qualitative | max | Usual | 0.25 | - |
| C2 | Skor Pengalaman | Quantitative | max | Linear | 0.20 | P, Q |
| C3 | Rating Kepuasan Klien | Quantitative | max | Gaussian | 0.20 | S |
| C4 | Jarak Geografis (KM) | Spatial | min | V-Shape | 0.15 | P |
| C5 | Tingkat Keaktifan | Quantitative | max | Level | 0.10 | P, Q |
| C6 | Sertifikasi Validitas | Quantitative | max | Usual | 0.10 | - |

### **Preference Functions (6 Types)**

1. **Usual** → Binary: 0 or 1
2. **U-Shape** → Threshold Q: 0 or 1 based on Q
3. **V-Shape** → Linear growth with threshold P
4. **Level** → Three zones: indifference (Q), preference (P), strong preference
5. **Linear** → Graduated preference between Q and P
6. **Gaussian** → Smooth exponential preference curve with Gaussian S parameter

---

## 🛠️ Tech Stack

### **Backend**
- **Framework**: Laravel 13.8 + PHP 8.3
- **ORM**: Eloquent (Laravel)
- **Database**: SQLite (default) / MySQL configurable
- **Authentication**: Laravel Breeze
- **Payment Gateway**: Midtrans PHP SDK v2.6

### **Frontend**
- **Templating**: Blade (Laravel)
- **CSS Framework**: Tailwind CSS 3.4 + Forms Plugin
- **JavaScript**: Alpine.js 3.4 (Reactivity)
- **Animations**: GSAP 3.15
- **Build Tool**: Vite 8.0 + Laravel Vite Plugin

### **Key Dependencies**
- `midtrans/midtrans-php` → Payment processing
- `laravel/tinker` → REPL debugging
- `fakerphp/faker` → Seeding
- `phpunit/phpunit` → Testing

### **Development Tools**
- `laravel/pint` → PHP Code Styling
- `laravel/pail` → Log viewer
- `laravel/pao` → Performance analysis
- `mockery/mockery` → Mocking framework

---

## 🏗️ System Architecture

### **Directory Structure**

```
sistem-konsultan-halal/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # MVC Controllers (17 controllers)
│   │   │   ├── AdminCriteriaController.php    # SPK criteria config
│   │   │   ├── AdminSpkController.php         # PROMETHEE II engine UI
│   │   │   ├── AdminConsultantController.php  # Master data konsultan
│   │   │   ├── AdminUserController.php        # User management
│   │   │   ├── AdminCertificateController.php # Certificate upload
│   │   │   ├── ClientDashboardController.php  # Client overview
│   │   │   ├── ClientPaymentController.php    # Midtrans integration
│   │   │   ├── ClientDocumentController.php   # Document upload/validation
│   │   │   ├── ClientProjectController.php    # Project intake
│   │   │   ├── ConsultantProjectController.php# Assignment & audit
│   │   │   ├── FinanceProjectController.php   # Invoice & payment tracking
│   │   │   └── ...
│   │   ├── Middleware/         # Auth, role-based guards
│   │   └── Requests/           # Form validation
│   ├── Models/                 # Eloquent Models
│   │   ├── User.php            # Auth user with role
│   │   ├── Consultant.php      # Konsultan data + geolocation
│   │   ├── ConsultantEvaluation.php # Historical performance
│   │   ├── Project.php         # Klien project requests
│   │   ├── Criteria.php        # SPK criteria config
│   │   ├── Criteria.php        # Payment & invoicing
│   │   ├── CompanyProfile.php  # Klien company metadata
│   │   └── ...
│   ├── Services/
│   │   └── PrometheeService.php # ⭐ Core SPK PROMETHEE II Engine
│   ├── Enums/                  # Role, Status enums
│   └── Providers/              # Service providers
├── routes/
│   ├── web.php                 # Main routing (4 role groups)
│   ├── auth.php                # Auth routes (Breeze)
│   └── console.php             # Artisan commands
├── resources/
│   ├── views/                  # Blade templates (Tailwind styled)
│   ├── css/                    # Global styles
│   └── js/                     # Alpine.js components
├── database/
│   ├── migrations/             # Schema definitions
│   ├── factories/              # Model factories
│   └── seeders/                # Dummy data seeding
├── config/
│   ├── app.php                 # App configuration
│   ├── database.php            # DB configuration
│   ├── services.php            # External services (Midtrans)
│   └── ...
├── public/                     # Static assets (compiled by Vite)
├── storage/                    # File uploads, logs, cache
├── tests/                      # PHPUnit tests
├── composer.json               # PHP dependencies
├── package.json                # Node.js dependencies
├── tailwind.config.js          # Tailwind configuration
├── vite.config.js              # Vite bundler config
├── .env.example                # Environment template
└── README.md                   # This file

```

### **Data Flow Architecture**

```
┌─────────────────┐
│   KLIEN (Web)   │  1. Pengajuan Proyek + Profil Perusahaan
└────────┬────────┘     (latitude, longitude, kategori industri)
         │
         ↓
┌─────────────────────────────────────┐
│   ClientProjectController.php       │  2. Validasi & Store Project
│   + CompanyProfileController.php    │     Middleware: ensure.profile.completed
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│    Project Model (Database)         │  3. Project state: 'intake'
│    + CompanyProfile                 │
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│   AdminSpkController.php            │  4. Admin trigger SPK computation
│   → AdminSpkController::            │
│      hitungSpkAjax()                │
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│  PrometheeService::                 │  5. CORE ALGORITHM
│  hitungRekomendasi($project)        │     ├─ Fetch criteria
│                                     │     ├─ Fetch active consultants
│                                     │     ├─ Build decision matrix
│                                     │     ├─ Pairwise comparison
│                                     │     ├─ Flow calculation
│                                     │     └─ Sort by Net Flow (Φ)
│  Returns: Ranked consultant array   │
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│   AdminSpkController::              │  6. Admin select & assign
│   tunjukKonsultan()                 │     (Update Project.consultant_id)
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│   Project State: 'assigned'         │  7. ClientPaymentController
│   + Payment records created         │     Termin 1: 60% invoice
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│   Consultant Dashboard              │  8. Konsultan akses
│   (ConsultantProjectController)     │     - View assignment
│                                     │     - Schedule audit
│                                     │     - Validate documents
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│   Finance Dashboard                 │  9. Finance verifikasi
│   (FinanceProjectController)        │     invoice & termin 2
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│  AdminCertificateController::       │  10. Admin upload sertifikat halal
│  upload()                           │      (File → Project.certificate)
└────────┬────────────────────────────┘
         │
         ↓
┌─────────────────────────────────────┐
│   Klien Dashboard (Certificate)     │  11. Klien download sertifikat
│   (ClientDashboardController)       │
└─────────────────────────────────────┘
```

---

## 🚀 Installation

### **Prerequisites**
- PHP 8.3+
- Composer
- Node.js 16+ & npm
- MySQL / SQLite
- Git

### **Quick Setup (1 Command)**

```bash
# Clone repository
git clone https://github.com/Dzanax-533/sistem-konsultan-halal.git
cd sistem-konsultan-halal

# Run setup (install dependencies + migrate + build frontend)
composer run setup
```

**Yang dilakukan `setup` script:**
1. `composer install` → Install PHP dependencies
2. Copy `.env.example` → `.env` (if not exists)
3. `php artisan key:generate` → Generate APP_KEY
4. `php artisan migrate --force` → Run database migrations
5. `npm install --ignore-scripts` → Install frontend deps
6. `npm run build` → Build Tailwind + Vite assets

### **Manual Setup (Step-by-Step)**

```bash
# 1. Install PHP dependencies
composer install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Database setup
php artisan migrate
php artisan db:seed  # Optional: seed dummy data

# 4. Install & build frontend
npm install
npm run build

# 5. Serve application
php artisan serve
```

### **Environment Variables** (.env)

```dotenv
# Application
APP_NAME="Sistem Konsultan Halal"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (SQLite by default)
DB_CONNECTION=sqlite
# OR MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=sistem_halal
# DB_USERNAME=root
# DB_PASSWORD=password

# Session & Cache
CACHE_STORE=database
SESSION_DRIVER=database

# Queue (for async tasks)
QUEUE_CONNECTION=database

# Midtrans Payment Gateway
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_IS_PRODUCTION=false

# Mail (for notifications)
MAIL_MAILER=log
```

### **Development Mode**

```bash
# Terminal 1: PHP server + queue listener + logs
composer run dev

# Terminal 2 (if separate): Frontend watcher
npm run dev

# Access: http://localhost:8000
```

---

## 🧪 Testing

### **Run Tests**

```bash
# All tests
composer test

# Specific test file
php artisan test tests/Unit/PrometheeServiceTest.php

# With coverage
php artisan test --coverage
```

### **PHPUnit Configuration**
- Config: `phpunit.xml`
- Test directory: `tests/`
- Database: SQLite in-memory (test database)

---

## 📊 Database Schema (Key Tables)

```sql
-- Users (Authentication)
users
├── id, name, email, password
├── role (admin|klien|konsultan|keuangan)
└── timestamps

-- Consultants (Master Data)
consultants
├── id, nama_konsultan, sertifikasi_no
├── latitude, longitude (Geolocation)
├── spesialisasi_industri
├── domisili, is_active
└── timestamps

-- Consultant Evaluations (Historical Scores)
consultant_evaluations
├── id, consultant_id, criteria_id
├── nilai (Score)
└── timestamps

-- Criteria (SPK Configuration)
criteria
├── id, kode (C1-C6), nama
├── tren (max|min), bobot
├── tipe_preferensi
├── param_p, param_q, param_s
└── timestamps

-- Projects (Klien Requests)
projects
├── id, klien_id, consultant_id
├── latitude, longitude (Lokasi audit)
├── status (intake|assigned|ongoing|completed)
├── jenis_layanan_id, tanggal_pengajuan
└── timestamps

-- Payments (Invoice & Termin)
payments
├── id, project_id
├── termin (1|2), nominal
├── status (pending|paid)
├── transaction_id (Midtrans)
└── timestamps

-- Project Documents
project_documents
├── id, project_id, document_type
├── file_path, status (uploaded|validated|rejected)
└── timestamps
```

---

## 📚 API/Routes Overview

### **Route Groups by Role**

#### **1. Admin Routes** (`/admin/*`)
```
GET    /admin/dashboard                 → Overview
GET    /admin/konfigurasi-kriteria      → Criteria editor
POST   /admin/konfigurasi-kriteria/simpan → Save criteria config
GET    /admin/spk-plotting              → Project list for SPK
GET    /admin/proyek/{id}/spk           → SPK recommendation view
GET    /admin/proyek/{id}/spk/hitung-ajax → Compute AJAX
POST   /admin/proyek/{id}/spk/tunjuk    → Assign consultant
GET/PUT /admin/kelola-konsultan/{id}    → Manage consultant data
```

#### **2. Klien Routes** (`/klien/*`)
```
GET    /klien/dashboard                          → Project overview
GET/POST /klien/profil                           → Company profile editor
GET/POST /klien/pengajuan                        → Create project request
GET    /klien/dokumen                           → Document list
POST   /klien/dokumen/upload                    → Upload documents
GET    /klien/pembayaran                        → Payment list
GET    /klien/pembayaran/{id}/snap-token        → Get Midtrans token
GET    /klien/pembayaran/{id}/sukses            → Payment callback
GET    /klien/status-sertifikasi                → Certification status
GET    /klien/konsultan-pendamping              → View assigned consultant
GET    /klien/sertifikat-halal                  → Download certificate
```

#### **3. Consultant Routes** (`/konsultan/*`)
```
GET    /konsultan/dashboard              → Assignment overview
GET    /konsultan/penugasan              → List assignments
GET    /konsultan/penugasan/{id}         → Assignment details
GET/POST /konsultan/jadwal-audit/{id}    → Schedule audit
GET    /konsultan/validasi-dokumen       → Document validation list
POST   /konsultan/dokumen/{id}/status    → Update document status
POST   /konsultan/proyek/{id}/unggah-audit → Upload audit report
```

#### **4. Finance Routes** (`/keuangan/*`)
```
GET    /keuangan/dashboard                    → Revenue overview
GET    /keuangan/penerbitan-invoice           → Invoice list
GET/POST /keuangan/proyek/{id}/verifikasi    → Verify & finalize
GET    /keuangan/monitoring-pembayaran       → Payment tracking
GET    /keuangan/laporan-keuangan            → Financial reports
GET    /keuangan/laporan-keuangan/export-pdf → PDF export
```

---

## 🎨 Screenshots & UI Components

**Implemented Pages:**
- ✅ Landing page (public)
- ✅ Login/Register (Laravel Breeze)
- ✅ Multi-role dashboards
- ✅ SPK criteria configuration interface (admin)
- ✅ SPK recommendation display (admin)
- ✅ Project intake form (klien)
- ✅ Payment gateway UI (Midtrans Snap)
- ✅ Document management interface
- ✅ Consultant assignment list
- ✅ Finance reports & exports

---

## 🔒 Security Features

- **Authentication**: Laravel Breeze (session-based + optional 2FA)
- **Authorization**: Role-based middleware (admin|klien|konsultan|keuangan)
- **CSRF Protection**: Token verification on all POST/PUT/DELETE
- **SQL Injection Prevention**: Eloquent ORM parameterized queries
- **Payment Webhook Verification**: Midtrans signature validation
- **File Upload Validation**: MIME type + size checking
- **Environment Variables**: Sensitive keys in `.env` (not in git)

---

## 🤝 Contributing

1. Fork repository
2. Create feature branch: `git checkout -b feature/nama-fitur`
3. Commit changes: `git commit -m "Add fitur baru"`
4. Push branch: `git push origin feature/nama-fitur`
5. Open Pull Request

---

## 📝 License

This project is licensed under the MIT License — see [LICENSE](./LICENSE) file for details.

---

## 👨‍💼 Author

**Dzanax-533**  
GitHub: [@Dzanax-533](https://github.com/Dzanax-533)

### **Project Created For**
Sistem Informasi & Sistem Pendukung Keputusan untuk Lembaga Sertifikasi Halal di Indonesia

---

## 📞 Support & Documentation

- **Issues**: Report bugs via [GitHub Issues](https://github.com/Dzanax-533/sistem-konsultan-halal/issues)
- **Discussions**: Q&A via [GitHub Discussions](https://github.com/Dzanax-533/sistem-konsultan-halal/discussions)
- **Laravel Docs**: https://laravel.com/docs
- **PROMETHEE II Reference**: Brans & Mareschal, Multicriteria Decision Methods

---

## 🗂️ Related Documentation

- [PROMETHEE II Algorithm Guide](./docs/promethee-ii-guide.md) *(if exists)*
- [API Endpoint Documentation](./docs/api-endpoints.md) *(if exists)*
- [Database Schema Diagram](./docs/database-schema.md) *(if exists)*

---

**Last Updated**: 2024  
**Laravel Version**: 13.8+  
**PHP Version**: 8.3+  
**Status**: Active Development ✅
