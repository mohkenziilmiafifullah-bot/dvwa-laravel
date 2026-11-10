@extends('layouts.app')
@section('title','Command Injection')
@section('content')
<h2>Vulnerability: Command Injection</h2>
<p>Form ini menjalankan <code>ping</code> ke alamat IP. Tujuan: jalankan perintah lain di server.</p>
<form method="POST" action="/vulnerabilities/exec">
<label>Masukkan alamat IP</label><input name="ip" placeholder="127.0.0.1">
@if($level==='impossible')<input type="hidden" name="user_token" value="{{ $token }}">@endif
<button name="Submit" value="Submit">Submit</button>
</form>
@if($out !== null)<pre>{{ $out }}</pre>@endif
@endsection
