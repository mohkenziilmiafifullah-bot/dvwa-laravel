@extends('layouts.app')
@section('title','File Inclusion')
@section('content')
<h2>Vulnerability: File Inclusion</h2>
<p>Parameter <code>page</code> menentukan file yang dibaca. Tujuan: baca file di luar folder aplikasi (mis. <code>win.ini</code> / <code>/etc/passwd</code>).</p>
<p>Contoh: <a href="/vulnerabilities/fi?page=file1.php">file1.php</a> |
<a href="/vulnerabilities/fi?page=file2.php">file2.php</a> |
<a href="/vulnerabilities/fi?page=file3.php">file3.php</a></p>
@if($err)<div class="box bad">{{ $err }}</div>@endif
@if($out !== null)<pre>{{ $out }}</pre>@endif
@endsection
