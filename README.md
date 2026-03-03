# 👕 SmartStore🤖

Selamat datang di repository **SmartStore**. Ini adalah proyek aplikasi e-commerce modern yang menggabungkan kekuatan **Laravel** untuk manajemen data dan **FastAPI (Python)** sebagai otak asisten suara pintar

---

## 🛠️ Prasyarat (Prerequisites)
Sebelum memulai, pastikan laptop kamu sudah terinstall:
- **XAMPP** (PHP 8.2+, MySQL/MariaDB)
- **Composer** (Dependency Manager PHP)
- **Node.js & NPM** (Untuk frontend assets)
- **Python 3.10+** (Untuk AI Server)
- **Git**

---

## 🚀 Langkah Instalasi (Step-by-Step)

### 1. Persiapan Database
1. Nyalakan **Apache** dan **MySQL** di XAMPP.
2. Buka `http://localhost/phpmyadmin`.
3. Buat database baru dengan nama: `toko_baju`.

### 2. Setup Backend (Laravel)
Buka terminal di folder utama proyek:
```bash
# Install library PHP
composer install

# Install library JavaScript
npm install && npm run build

# Copy file environment
cp .env.example .env

# Generate security key
php artisan key:generate

PENTING: Buka file .env dan sesuaikan bagian database:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_baju
DB_USERNAME=root
DB_PASSWORD=

Setelah itu, jalankan migrasi untuk membuat tabel:
php artisan migrate

Setup AI Server (FastAPI)
Buka terminal baru dan masuk ke folder AI:

cd ai-assistant

# Buat Virtual Environment agar library tidak berantakan
python -m venv venv

# Aktifkan Venv
# (Windows):
venv\Scripts\activate
# (Mac/Linux):
source venv/bin/activate

# Install library yang dibutuhkan
pip install fastapi uvicorn requests flask-cors pydantic

🏃‍♂️ Menjalankan Aplikasi
Kamu harus menjalankan dua server sekaligus:

Jalankan Laravel (Terminal 1):
    php artisan serve
    Aplikasi akan jalan di: http://127.0.0.1:8000
Jalankan  AI (Terminal 2):
    cd ai-assistant
    # Pastikan venv aktif
    python ai_server.py
    AI akan jalan di: http://127.0.0.1:5000
🤖 Cara Menggunakan  AI
Buka browser ke http://127.0.0.1:8000.

Lakukan Registrasi akun terlebih dahulu di menu yang tersedia.

Login ke dalam sistem.

Klik ikon Robot (Si Juki) di pojok kanan bawah.

Klik tombol 🎤 Bicara.

Ucapkan kalimat seperti:

"Cek stok baju brand H&M"

"Ada stok celana apa?"

Si Juki akan memproses suara kamu dan menjawab langsung melalui suara speaker.