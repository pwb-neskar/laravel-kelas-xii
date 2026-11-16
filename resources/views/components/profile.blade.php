@extends('templates.index')

@section('content')
<div class="container" style="padding: 40px 0;">
  <h3>Profil Saya</h3>

  @if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
  @endif

  <table class="table">
    <tr><th style="width:150px">Nama</th><td>{{ $user->name }}</td></tr>
    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
    <tr><th>Alamat</th><td>{{ $user->profile->alamat }}</td></tr>
    <tr><th>Umur</th><td>{{ $user->profile->umur }}</td></tr>
    <tr><th>Bio</th><td>{{ $user->profile->bio }}</td></tr>
  </table>

  <a href="{{ route('profile.edit') }}" class="btn btn-primary">Ubah Profil</a>
</div>
@endsection