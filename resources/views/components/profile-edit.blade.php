@extends('templates.index')

@section('content')
<div class="container" style="padding: 40px 0;">
  <h3>Ubah Profil</h3>

  <form action="{{ route('profile.update') }}" method="post">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
      @error('name') <p style="color:red">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
      @error('email') <p style="color:red">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label>Alamat</label>
      <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user->profile->alamat) }}">
      @error('alamat') <p style="color:red">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label>Umur</label>
      <input type="number" name="umur" class="form-control" value="{{ old('umur', $user->profile->umur) }}">
      @error('umur') <p style="color:red">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label>Bio</label>
      <textarea name="bio" rows="4" class="form-control">{{ old('bio', $user->profile->bio) }}</textarea>
      @error('bio') <p style="color:red">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('profile.show') }}" class="btn btn-default">Batal</a>
  </form>
</div>
@endsection