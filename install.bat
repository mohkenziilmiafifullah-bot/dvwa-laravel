@echo off
setlocal
title DVWA Laravel - Install
cd /d "%~dp0"
call "%~dp0_env.bat"
if errorlevel 1 ( pause & exit /b 1 )

echo.
echo [1/6] Memeriksa koneksi MySQL ...
php tools\db.php check
if errorlevel 1 (
  echo [ERROR] MySQL tidak bisa dihubungi di %DB_HOST%:%DB_PORT%. Jalankan Laragon, klik Start All, lalu ulangi.
  pause & exit /b 1
)

echo [2/6] Membuat database %DB_NAME% ...
php tools\db.php create
if errorlevel 1 ( pause & exit /b 1 )

echo [3/6] Memasang kerangka Laravel 12 lewat Composer, butuh internet ...
if not exist "src\artisan" (
  call %COMPOSER% create-project "laravel/laravel:12.*" src --prefer-dist --no-interaction
  if errorlevel 1 ( echo [ERROR] create-project gagal. & pause & exit /b 1 )
) else (
  echo      src\ sudah ada, dilewati.
)

echo [4/6] Menyalin kode DVWA ...
xcopy "overlay" "src\" /E /Y /I /Q /H >nul
if errorlevel 1 ( echo [ERROR] Gagal menyalin overlay. & pause & exit /b 1 )

echo [5/6] Mengatur file .env ...
php tools\setup-env.php "src\.env"
if errorlevel 1 ( pause & exit /b 1 )

echo [6/6] Migrasi dan seed database ...
pushd src
php artisan config:clear >nul
php artisan migrate:fresh --seed --force
if errorlevel 1 ( popd & echo [ERROR] Migrasi gagal. & pause & exit /b 1 )
popd

echo.
echo ==================================================
echo  Instalasi selesai.
echo  Jalankan start.bat, lalu buka http://%APP_HOST%:%APP_PORT%
echo  Login: admin / password
echo ==================================================
pause
endlocal
