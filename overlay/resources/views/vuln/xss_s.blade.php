@extends('layouts.app')
@section('title','XSS Stored')
@section('content')
<h2>Vulnerability: Stored Cross Site Scripting (XSS)</h2>
<p>Tujuan: simpan JavaScript di buku tamu sehingga jalan tiap halaman dibuka.</p>
<form method="POST" action="/vulnerabilities/xss_s">
<label>Nama</label><input name="txtName" maxlength="{{ in_array($level,['low','medium']) ? 10 : 100 }}">
<label>Pesan</label><textarea name="mtxMessage" rows="3" maxlength="300"></textarea>
@if($level==='impossible')<input type="hidden" name="user_token" value="{{ $token }}">@endif
<div><button name="btnSign" value="1">Sign Guestbook</button>
<button name="btnClear" value="1" style="background:#b91c1c">Clear Guestbook</button></div>
</form>
@foreach($entries as $e)
<div class="box">Nama: {!! $e->name !!}<br>Pesan: {!! $e->comment !!}</div>
@endforeach
@endsection
