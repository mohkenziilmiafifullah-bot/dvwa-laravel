@echo off
setlocal
title DVWA Laravel - Server
cd /d "%~dp0"
call "%~dp0_env.bat"
if errorlevel 1 ( pause & exit /b 1 )

if not exist "src\artisan" (
  echo [INFO] Belum terinstal. Menjalankan install.bat ...
  call install.bat
  if errorlevel 1 exit /b 1
)

php tools\db.php check
if errorlevel 1 (
  echo [ERROR] MySQL belum jalan. Buka Laragon, klik Start All, lalu ulangi.
  pause & exit /b 1
)

echo.
echo DVWA Laravel berjalan di http://%APP_HOST%:%APP_PORT%   Login: admin / password
echo HANYA untuk localhost. Tekan Ctrl+C untuk berhenti.
echo.
start "" /min cmd /c "timeout /t 3 /nobreak >nul & start http://%APP_HOST%:%APP_PORT%"
cd src
php artisan serve --host=%APP_HOST% --port=%APP_PORT%
endlocal
