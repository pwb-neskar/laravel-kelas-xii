@extends('templates.index')

@section('content')
<div class="container" style="padding:30px 15px">
  <h3>Edit Profil</h3>
  <form action="{{ route('profile.update') }}" method="POST" style="max-width:600px">
    @csrf
    @method('PUT')

    <div class="form-group @error('name') has-error @enderror">
      <label>Nama</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
      @error('name') <span class="help-block">{{ $message }}</span> @enderror
    </div>
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

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('profile.show') }}" class="btn btn-default">Batal</a>
  </form>
</div>
@endsection
