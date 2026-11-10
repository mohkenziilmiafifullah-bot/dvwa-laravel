@extends('layouts.app')
@section('title','File Upload')
@section('content')
<h2>Vulnerability: File Upload</h2>
<p>Tujuan: unggah file yang bukan gambar dan jalankan di server. File tersimpan di <code>public/hackable/uploads/</code>.</p>
<form method="POST" action="/vulnerabilities/upload" enctype="multipart/form-data">
<label>Pilih gambar</label><input type="file" name="uploaded">
@if($level==='impossible')<input type="hidden" name="user_token" value="{{ $token }}">@endif
<button name="Upload" value="Upload">Upload</button>
</form>
@if($out)<div class="box {{ $out[0] }}">{{ $out[1] }}
@if($out[0]==='ok')<br><a href="/{{ explode(' ',$out[1])[0] }}" target="_blank">Buka file</a>@endif</div>@endif
@endsection
