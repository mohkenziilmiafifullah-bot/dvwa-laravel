@extends('layouts.app')
@php $plain = true; @endphp
@section('title','Setup')
@section('content')
<h2>Setup / Reset DB</h2>
<p>Database: <code>{{ $info['db'] }}</code><br>Jumlah user: <code>{{ $info['users'] }}</code><br>PHP: <code>{{ PHP_VERSION }}</code> ({{ PHP_OS_FAMILY }})</p>
@if($msg)<div class="box ok">{{ $msg }}</div>@endif
<form method="POST" action="/setup"><button style="margin:0">Create / Reset Database</button></form>
<p><a href="/">&larr; Kembali</a></p>
@endsection
