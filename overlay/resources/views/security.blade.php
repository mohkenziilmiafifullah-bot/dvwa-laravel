@extends('layouts.app')
@section('title','DVWA Security')
@section('content')
<h2>DVWA Security</h2>
<h3>Security Level</h3>
<p>Level saat ini: <b>{{ $level }}</b></p>
<form method="POST" action="/security">
<select name="security">
@foreach(['low','medium','high','impossible'] as $l)
<option value="{{ $l }}" @selected($level===$l)>{{ ucfirst($l) }}</option>
@endforeach
</select>
<button>Submit</button>
</form>
<ul>
<li><b>Low</b>: sama sekali tidak ada proteksi.</li>
<li><b>Medium</b>: proteksi buruk, bisa dilewati.</li>
<li><b>High</b>: proteksi lebih sulit, masih ada celah.</li>
<li><b>Impossible</b>: kode aman (token, prepared statement, whitelist).</li>
</ul>
@endsection
