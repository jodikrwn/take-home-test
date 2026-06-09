# Ship Maintenance Management API

REST API untuk mengelola data kapal dan log pemeliharaan, dibangun dengan Laravel 11.

## Prerequisites

- PHP >= 8.2
- Composer >= 2.x
- MySQL >= 8.0

## Instalasi

### 1. Clone & Install Dependencies

```bash
git clone https://github.com/jodikrwn/take-home-test
cd take-home-test
composer install
```

### 2. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuai environment lokal:

```env
APP_NAME="Ship Maintenance API"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=take_home_test
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database
```

### 3. Buat Database

```sql
CREATE DATABASE take_home_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Seeder mengisi: 60 kapal, 550 log pemeliharaan, dan setting default email manajer.

## Konfigurasi Email

Secara default `MAIL_MAILER=log` — tidak butuh SMTP.
Email dirender penuh dan ditulis ke `storage/logs/laravel.log`.

Jika tidak dikonfigurasi, notifikasi diabaikan dan dicatat sebagai warning — tidak ada error pada endpoint.

Untuk SMTP sungguhan, tambahkan di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Ship Maintenance"
```

Email tujuan dikonfigurasi di tabel `settings` (key: `operational_manager_email`, default: `manager@example.com`).

## Menjalankan Server

```bash
# Terminal 1 — API server
php artisan serve

# Terminal 2 — Queue worker (untuk notifikasi email)
php artisan queue:work
```

API tersedia di `http://127.0.0.1:8000/api`.

---

## API Endpoints

Base URL: `/api` | Rate Limit: **60 requests/menit per IP**

### GET /api/ships

Menampilkan daftar kapal beserta servis terakhir dan total biaya servis.

**Query Parameters (opsional):**

| Parameter | Tipe | Keterangan |
|-----------|------|------------|
| `min_biaya` | numeric | Minimal total biaya servis |
| `max_biaya` | numeric | Maksimal total biaya servis |
| `status` | string | Filter status: `planned`, `ongoing`, `completed` |
| `page` | integer | Halaman (default: 1, 15 item/halaman) |

**Contoh Request:**

```
GET /api/ships?status=ongoing&min_biaya=1000000
```

**Response 200:**

```json
{
  "data": [
    {
      "id": 1,
      "nama": "KM Nusantara Jaya",
      "kode_kapal": "KM-001",
      "tahun_pembuatan": 2010,
      "servis_terakhir": {
        "id": 42,
        "ship_id": 1,
        "tanggal_servis": "2025-12-01",
        "jenis_servis": "Overhaul Mesin",
        "biaya": "5000000.00",
        "status": "completed"
      },
      "total_biaya_servis": "12500000.00"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/ships?page=1",
    "last": "http://127.0.0.1:8000/api/ships?page=4",
    "prev": null,
    "next": "http://127.0.0.1:8000/api/ships?page=2"
  },
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 60
  }
}
```

**Response 422 (filter tidak valid):**

```json
{
  "message": "The status field must be one of planned, ongoing, completed.",
  "errors": {
    "status": ["The status field must be one of planned, ongoing, completed."]
  }
}
```

---

### PATCH /api/maintenance-logs/{id}/complete

Menandai log servis sebagai selesai dan menjadwalkan servis berikutnya 6 bulan ke depan.

**Request Body:** Tidak diperlukan.

**Contoh Request:**

```
PATCH /api/maintenance-logs/42/complete
```

**Response 200:**

```json
{
  "data": {
    "completed": {
      "id": 42,
      "ship_id": 1,
      "tanggal_servis": "2025-12-01",
      "jenis_servis": "Overhaul Mesin",
      "biaya": "5000000.00",
      "status": "completed"
    },
    "next_scheduled": {
      "id": 101,
      "ship_id": 1,
      "tanggal_servis": "2026-06-01",
      "jenis_servis": "Overhaul Mesin",
      "biaya": "0.00",
      "status": "planned"
    }
  },
  "message": "Servis ditandai selesai. Jadwal berikutnya: 2026-06-01."
}
```

**Response 422 (sudah completed):**

```json
{
  "message": "Servis ini sudah berstatus completed.",
  "errors": {
    "status": ["Servis ini sudah berstatus completed."]
  }
}
```

**Response 404 (ID tidak ditemukan):**

```json
{
  "message": "No query results for model [App\\Models\\MaintenanceLog] 999"
}
```

---

## Rate Limiting

Semua endpoint `/api` dibatasi **60 requests per menit per IP**.
Saat limit tercapai, response `429 Too Many Requests` dikembalikan dengan header `Retry-After`.
