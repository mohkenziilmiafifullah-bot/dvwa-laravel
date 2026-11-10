@extends('layouts.app')
@php $plain = true; @endphp
@section('title','Login')
@section('content')
<form method="POST" action="/login" style="border:0;background:transparent;padding:0">
<div style="text-align:center;margin-bottom:10px"><b>Login</b></div>
@if($error)<div class="box bad" style="text-align:center">{{ $error }}</div>@endif
<label>Username</label><input name="username" autofocus style="width:100%">
<label>Password</label><input type="password" name="password" style="width:100%">
<button>Login</button>
</form>
<p><a href="/setup">Setup / Reset Database</a> &mdash; default: admin / password</p>
@endsection
