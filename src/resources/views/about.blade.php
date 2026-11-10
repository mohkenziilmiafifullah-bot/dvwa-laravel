@extends('layouts.app')
@section('title','About')
@section('content')
<h2>About</h2>
<p>DVWA Laravel &mdash; adaptasi Damn Vulnerable Web Application (proyek asli: dvwa.co.uk) menggunakan Laravel 12 dan MySQL.</p>
<p>PHP {{ PHP_VERSION }} &middot; Laravel {{ app()->version() }}</p>
@endsection
