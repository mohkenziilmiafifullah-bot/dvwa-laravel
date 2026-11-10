DVWA LARAVEL  (Damn Vulnerable Web App versi Laravel 12 + MySQL)
==============================================================
Aplikasi SENGAJA RENTAN untuk belajar keamanan web. Jalankan HANYA di komputer lokal.
Jangan upload ke hosting / server publik.

KEBUTUHAN
- Windows + Laragon (PHP 8.2+, MySQL, Composer). Laragon: klik "Start All" dulu.
- Internet saat install pertama (Composer mengunduh Laravel).

CARA PAKAI
1. Ekstrak zip ini (path tanpa spasi lebih aman, mis. E:\laragon\www\dvwa-laravel).
2. Jalankan Laragon, klik Start All (MySQL harus hidup).
3. Klik dua kali install.bat   -> buat database, pasang Laravel, migrasi + seed.
4. Klik dua kali start.bat     -> server di http://127.0.0.1:8000
5. Login: admin / password
6. update.bat                  -> sinkron kode + composer install + migrate.
   update.bat reset            -> reset database.
   update.bat full             -> composer update (naikkan paket).

PENGATURAN DB (default Laragon: root tanpa password): edit bagian atas _env.bat.

AKUN BAWAAN: admin/password, gordonb/abc123, 1337/charley, pablo/letmein, smithy/password

MODUL: Brute Force, Command Injection, CSRF, File Inclusion, File Upload,
SQL Injection, SQL Injection (Blind), XSS Reflected, XSS Stored.
Level: low, medium, high, impossible (menu DVWA Security).

KODE: overlay\ disalin ke src\ (kerangka Laravel). Controller utama:
src\app\Http\Controllers\DvwaController.php. Ubah kode di overlay\, lalu jalankan update.bat.

CATATAN: server hanya bind ke 127.0.0.1. Jangan ubah APP_HOST jadi 0.0.0.0.
