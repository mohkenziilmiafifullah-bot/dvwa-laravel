<?php

use App\Http\Controllers\DvwaController as D;
use App\Http\Middleware\DvwaAuth;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;

// CSRF bawaan Laravel sengaja dimatikan: modul CSRF DVWA memakai token buatan sendiri.
Route::withoutMiddleware([ValidateCsrfToken::class])->group(function () {
    Route::match(['get', 'post'], '/login', [D::class, 'login']);
    Route::get('/logout', [D::class, 'logout']);
    Route::match(['get', 'post'], '/setup', [D::class, 'setup']);

    Route::middleware(DvwaAuth::class)->group(function () {
        Route::get('/', [D::class, 'home']);
        Route::match(['get', 'post'], '/security', [D::class, 'security']);
        Route::get('/vulnerabilities/brute', [D::class, 'brute']);
        Route::match(['get', 'post'], '/vulnerabilities/exec', [D::class, 'exec']);
        Route::get('/vulnerabilities/csrf', [D::class, 'csrf']);
        Route::get('/vulnerabilities/fi', [D::class, 'fi']);
        Route::match(['get', 'post'], '/vulnerabilities/upload', [D::class, 'upload']);
        Route::match(['get', 'post'], '/vulnerabilities/sqli', [D::class, 'sqli']);
        Route::match(['get', 'post'], '/vulnerabilities/sqli_blind', [D::class, 'sqliBlind']);
        Route::get('/vulnerabilities/xss_r', [D::class, 'xssR']);
        Route::match(['get', 'post'], '/vulnerabilities/xss_s', [D::class, 'xssS']);
    });
});
