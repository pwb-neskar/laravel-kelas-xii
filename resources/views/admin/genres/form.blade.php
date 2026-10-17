@extends('admin.layouts.app')
@section('title', $genre->exists ? 'Edit Genre' : 'Tambah Genre')

@section('content')
<h2 style="margin-top:0">{{ $genre->exists ? 'Edit Genre' : 'Tambah Genre' }}</h2>

<div class="panel panel-default"><div class="panel-body">
<form action="{{ $genre->exists ? route('admin.genres.update', $genre) : route('admin.genres.store') }}" method="POST">
  @csrf
  @if ($genre->exists) @method('PUT') @endif

  <div class="form-group @error('name') has-error @enderror">
    <label>Nama Genre</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $genre->name) }}">
    @error('name') <span class="help-block">{{ $message }}</span> @enderror
  </div>

  <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
  <a href="{{ route('admin.genres.index') }}" class="btn btn-default">Batal</a>
</form>
</div></div>
@endsection
