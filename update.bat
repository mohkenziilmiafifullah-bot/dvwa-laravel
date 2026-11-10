@echo off
setlocal
title DVWA Laravel - Update
cd /d "%~dp0"
call "%~dp0_env.bat"
if errorlevel 1 ( pause & exit /b 1 )

if not exist "src\artisan" (
  echo [INFO] Belum terinstal. Menjalankan install.bat ...
  call install.bat
  exit /b %errorlevel%
)

echo [1/4] Menyalin kode DVWA terbaru ...
xcopy "overlay" "src\" /E /Y /I /Q /H >nul

pushd src
echo [2/4] Composer ...
if /i "%~1"=="full" (
  call %COMPOSER% update --no-interaction
) else (
  call %COMPOSER% install --no-interaction
)
if errorlevel 1 ( popd & echo [ERROR] Composer gagal. & pause & exit /b 1 )

echo [3/4] Database ...
if /i "%~1"=="reset" (
  php artisan migrate:fresh --seed --force
) else (
  php artisan migrate --force
)
if errorlevel 1 ( popd & echo [ERROR] Migrasi gagal. & pause & exit /b 1 )

echo [4/4] Membersihkan cache ...
php artisan optimize:clear >nul
popd

echo.
echo Update selesai.  Opsi: update.bat reset = reset database, update.bat full = composer update.
pause
endlocal
