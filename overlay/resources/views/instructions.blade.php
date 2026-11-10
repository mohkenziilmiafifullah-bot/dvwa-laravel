@extends('layouts.app')
@section('title','Instructions')
@section('content')
<h2>Instructions</h2>
<p><b>Damn Vulnerable Web Application (DVWA)</b> versi Laravel + MySQL adalah aplikasi web yang sengaja dibuat rentan, untuk belajar keamanan web secara legal di lab sendiri.</p>
<h3>Cara belajar</h3>
<ol>
<li>Atur tingkat kesulitan di <a href="/security">DVWA Security</a>: <b>low</b> (tanpa proteksi), <b>medium</b> (proteksi lemah), <b>high</b> (proteksi hampir benar), <b>impossible</b> (kode aman).</li>
<li>Pilih modul di menu kiri, pahami celahnya, lalu coba eksploitasi.</li>
<li>Naikkan level, bandingkan kodenya di <code>src/app/Http/Controllers/DvwaController.php</code>.</li>
<li>Kalau data rusak: <a href="/setup">Setup / Reset DB</a>.</li>
</ol>
<div class="warn"><b>Peringatan:</b> jangan pasang aplikasi ini di server publik. Jalankan hanya di localhost.</div>
@endsection
