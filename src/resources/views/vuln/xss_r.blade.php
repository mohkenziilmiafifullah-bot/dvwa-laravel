@extends('layouts.app')
@section('title','XSS Reflected')
@section('content')
<h2>Vulnerability: Reflected Cross Site Scripting (XSS)</h2>
<p>Tujuan: sisipkan JavaScript lewat parameter <code>name</code>.</p>
<form method="GET" action="/vulnerabilities/xss_r">
<label>Siapa namamu?</label><input name="name" autocomplete="off">
@if($level==='impossible')<input type="hidden" name="user_token" value="{{ $token }}">@endif
<button>Submit</button>
</form>
@if($out !== null)<pre>{!! $out !!}</pre>@endif
@endsection
