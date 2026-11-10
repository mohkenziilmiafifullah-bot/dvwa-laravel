@extends('layouts.app')
@section('title','SQL Injection')
@section('content')
<h2>Vulnerability: SQL Injection{{ $blind ? ' (Blind)' : '' }}</h2>
<p>Tujuan: tampilkan seluruh user, lalu ambil hash password dari tabel <code>dvwa_users</code>.@if($blind) Halaman ini hanya menjawab ada / tidak ada (boolean &amp; time-based).@endif</p>
<form method="{{ $level==='low' ? 'GET' : 'POST' }}" action="{{ $blind ? '/vulnerabilities/sqli_blind' : '/vulnerabilities/sqli' }}">
<label>User ID</label>
@if($level==='medium')
<select name="id">@foreach([1,2,3,4,5] as $i)<option value="{{ $i }}">{{ $i }}</option>@endforeach</select>
@else
<input name="id" autocomplete="off">
@endif
@if($level==='impossible')<input type="hidden" name="user_token" value="{{ $token }}">@endif
<button name="Submit" value="Submit">Submit</button>
</form>
@if($msg)<div class="box {{ $blind ? '' : 'bad' }}">{{ $msg }}</div>@endif
@if($rows)@foreach($rows as $row)
<pre>ID: {{ $id }}
First name: {{ $row->first_name }}
Surname: {{ $row->last_name }}</pre>
@endforeach @endif
@endsection
