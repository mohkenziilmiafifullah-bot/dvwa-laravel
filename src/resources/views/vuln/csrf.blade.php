@extends('layouts.app')
@section('title','CSRF')
@section('content')
<h2>Vulnerability: Cross Site Request Forgery (CSRF)</h2>
<p>Tujuan: buat halaman/link lain yang mengganti password admin tanpa sepengetahuan korban yang sedang login.</p>
<form method="GET" action="/vulnerabilities/csrf">
@if($level==='impossible')<label>Password saat ini</label><input type="password" name="password_current">@endif
<label>Password baru</label><input type="password" name="password_new" autocomplete="off">
<label>Konfirmasi password baru</label><input type="password" name="password_conf" autocomplete="off">
@if(in_array($level,['high','impossible']))<input type="hidden" name="user_token" value="{{ $token }}">@endif
<button name="Change" value="Change">Change</button>
</form>
@if($out)<div class="box {{ $out[0] }}">{{ $out[1] }}</div>@endif
@endsection
