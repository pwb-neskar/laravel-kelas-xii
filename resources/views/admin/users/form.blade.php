@extends('admin.layouts.app')
@section('title', $user->exists ? 'Edit User' : 'Tambah User')

@section('content')
<h2 style="margin-top:0">{{ $user->exists ? 'Edit User' : 'Tambah User' }}</h2>

<div class="panel panel-default"><div class="panel-body">
<form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
  @csrf
  @if ($user->exists) @method('PUT') @endif

  <div class="row">
    <div class="col-sm-6">
  <div class="form-group @error('name') has-error @enderror">
    <label>Nama</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
    @error('name') <span class="help-block">{{ $message }}</span> @enderror
  </div>
    </div>
    <div class="col-sm-6">
  <div class="form-group @error('email') has-error @enderror">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
    @error('email') <span class="help-block">{{ $message }}</span> @enderror
  </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
  <div class="form-group @error('password') has-error @enderror">
    <label>Password {{ $user->exists ? '(kosongkan jika tidak diganti)' : '' }}</label>
    <input type="password" name="password" class="form-control" autocomplete="new-password">
    @error('password') <span class="help-block">{{ $message }}</span> @enderror
  </div>
    </div>
    <div class="col-sm-6">
  <div class="form-group @error('role_id') has-error @enderror">
    <label>Role</label>
    <select name="role_id" class="form-control">
      @foreach ($roles as $opt)
        <option value="{{ $opt->id }}" {{ old('role_id', $user->role_id ?? 1) == $opt->id ? 'selected' : '' }}>{{ $opt->name }}</option>
      @endforeach
    </select>
    @error('role_id') <span class="help-block">{{ $message }}</span> @enderror
  </div>
    </div>
  </div>
  <hr>
  <h4>Profil</h4>
  <div class="form-group @error('umur') has-error @enderror">
    <label>Umur</label>
    <input type="number" name="umur" class="form-control" value="{{ old('umur', $user->profile->umur ?? '') }}">
    @error('umur') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('bio') has-error @enderror">
    <label>Bio</label>
    <textarea name="bio" rows="3" class="form-control">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
    @error('bio') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('alamat') has-error @enderror">
    <label>Alamat</label>
    <textarea name="alamat" rows="3" class="form-control">{{ old('alamat', $user->profile->alamat ?? '') }}</textarea>
    @error('alamat') <span class="help-block">{{ $message }}</span> @enderror
  </div>

  <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
  <a href="{{ route('admin.users.index') }}" class="btn btn-default">Batal</a>
</form>
</div></div>
@endsection
