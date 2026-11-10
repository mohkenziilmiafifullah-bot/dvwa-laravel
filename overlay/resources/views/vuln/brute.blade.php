@extends('layouts.app')
@section('title','Brute Force')
@section('content')
<h2>Vulnerability: Brute Force</h2>
<p>Tujuan: temukan password user <b>admin</b> (atau lewati login tanpa password).</p>
<form method="GET" action="/vulnerabilities/brute">
<label>Username</label><input name="username">
<label>Password</label><input type="password" name="password" autocomplete="off">
@if(in_array($level,['high','impossible']))<input type="hidden" name="user_token" value="{{ $token }}">@endif
<button name="Login" value="Login">Login</button>
</form>
@if($out)<div class="box {{ $out[0] }}">{{ $out[1] }}</div>@endif
@endsection
