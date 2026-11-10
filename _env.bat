@echo off
rem ===== Konfigurasi (ubah jika perlu) =====
set "DB_HOST=127.0.0.1"
set "DB_PORT=3306"
set "DB_NAME=dvwa_laravel"
set "DB_USER=root"
set "DB_PASS="
set "APP_HOST=127.0.0.1"
set "APP_PORT=8000"

rem ===== Deteksi Laragon, PHP, Composer =====
set "LARAGON="
if defined LARAGON_ROOT if exist "%LARAGON_ROOT%\bin\php" set "LARAGON=%LARAGON_ROOT%"
if not defined LARAGON for %%D in (E C D F) do if not defined LARAGON if exist "%%D:\laragon\bin\php" set "LARAGON=%%D:\laragon"

where php >nul 2>&1
if errorlevel 1 if defined LARAGON for /d %%P in ("%LARAGON%\bin\php\php-*") do set "PATH=%%P;%PATH%"

set "COMPOSER=composer"
where composer >nul 2>&1
if errorlevel 1 if defined LARAGON if exist "%LARAGON%\bin\composer\composer.bat" set "PATH=%LARAGON%\bin\composer;%PATH%"
where composer >nul 2>&1
if errorlevel 1 if defined LARAGON if exist "%LARAGON%\bin\composer\composer.phar" set "COMPOSER=php "%LARAGON%\bin\composer\composer.phar""

where php >nul 2>&1
if errorlevel 1 (
  echo [ERROR] PHP tidak ditemukan. Pasang Laragon atau tambahkan PHP ke PATH.
  exit /b 1
)
php -r "exit(version_compare(PHP_VERSION,'8.2.0','>=')?0:1);"
if errorlevel 1 (
  echo [ERROR] Laravel 12 membutuhkan PHP 8.2 atau lebih baru.
  exit /b 1
)
php -m | findstr /i "pdo_mysql" >nul
if errorlevel 1 (
  echo [ERROR] Ekstensi pdo_mysql belum aktif di PHP.
  exit /b 1
)
exit /b 0
