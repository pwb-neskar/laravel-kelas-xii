@extends('templates.index')

@section('content')
<div class="container" style="padding:30px 15px">
  <h3>Profil Saya</h3>
  <table class="table table-bordered" style="max-width:600px">
    <tr><th width="150">Nama</th><td>{{ $user->name }}</td></tr>
    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
    <tr><th>Role</th><td>{{ $user->role->name ?? '-' }}</td></tr>
    <tr><th>Umur</th><td>{{ $user->profile->umur ?? '-' }}</td></tr>
    <tr><th>Bio</th><td>{{ $user->profile->bio ?? '-' }}</td></tr>
    <tr><th>Alamat</th><td>{{ $user->profile->alamat ?? '-' }}</td></tr>
  </table>
  <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
</div>
@endsection
