@extends('layouts.app')
@section('title','Home')
@section('content')
<h2>Selamat datang di DVWA Laravel</h2>
<p>Aplikasi web <b>sengaja rentan</b> berbasis Laravel + MySQL untuk belajar keamanan web: mengenali, mengeksploitasi (di lab sendiri), lalu memperbaiki celah.</p>
<div class="warn"><b>Peringatan:</b> jangan pernah mengunggah aplikasi ini ke server publik/hosting. Jalankan hanya di komputer lokal (server berjalan di 127.0.0.1). Aplikasi ini memuat celah nyata, termasuk eksekusi perintah dan unggah file.</div>
<h3>Cara belajar</h3>
<ol>
<li>Atur tingkat kesulitan di menu <a href="/security">DVWA Security</a>: <b>low</b> (tanpa proteksi), <b>medium</b> (proteksi lemah), <b>high</b> (proteksi hampir benar), <b>impossible</b> (kode aman sebagai contoh perbaikan).</li>
<li>Pilih modul di menu kiri, pahami celahnya, lalu coba eksploitasi.</li>
<li>Naikkan level dan bandingkan perbedaannya. Kode ada di <code>src/app/Http/Controllers/DvwaController.php</code>.</li>
<li>Kalau data rusak, buka <a href="/setup">Setup / Reset DB</a>.</li>
</ol>
<h3>Modul</h3>
<p>Brute Force, Command Injection, CSRF, File Inclusion, File Upload, SQL Injection, SQL Injection (Blind), XSS Reflected, XSS Stored.</p>
@endsection
