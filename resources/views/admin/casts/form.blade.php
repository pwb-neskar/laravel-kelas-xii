@extends('admin.layouts.app')
@section('title', $cast->exists ? 'Edit Cast' : 'Tambah Cast')

@section('content')
<h2 style="margin-top:0">{{ $cast->exists ? 'Edit Cast' : 'Tambah Cast' }}</h2>

<div class="panel panel-default"><div class="panel-body">
<form action="{{ $cast->exists ? route('admin.casts.update', $cast) : route('admin.casts.store') }}" method="POST">
  @csrf
  @if ($cast->exists) @method('PUT') @endif

  <div class="form-group @error('name') has-error @enderror">
    <label>Nama</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $cast->name) }}">
    @error('name') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('age') has-error @enderror">
    <label>Umur</label>
    <input type="number" name="age" class="form-control" value="{{ old('age', $cast->age) }}">
    @error('age') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('bio') has-error @enderror">
    <label>Bio</label>
    <textarea name="bio" rows="4" class="form-control">{{ old('bio', $cast->bio) }}</textarea>
    @error('bio') <span class="help-block">{{ $message }}</span> @enderror
  </div>

  <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
  <a href="{{ route('admin.casts.index') }}" class="btn btn-default">Batal</a>
</form>
</div></div>
@endsection
