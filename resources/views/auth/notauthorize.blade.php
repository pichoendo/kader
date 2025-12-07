@extends('layouts.warn')
@section('content')
<div class="container-xxl container-p-y">
      <div class="misc-wrapper">
        <h2 class="mb-1 mx-2">Anda Tidak Di Izinkan Mengakses Halaman ini !</h2>
        <p class="mb-4 mx-2">
          Anda Tidak Di izinkan Untuk Mengakses Informasi ini, Silahkan Menghubungi Admin Jika Anda Membutuhkan Informasi Lebih Lanjut.
        </p>
        <a href="{{route('dashboard')}}" class="btn btn-primary mb-4">Dashboard</a>
        <div class="mt-4">

        </div>
      </div>
    </div>
@endsection
