@extends('templates.index')

@section('content')
@php($editing = $cast->exists)
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: {{ $editing ? 'Ubah' : 'Tambah' }} Cast</h3>
  @include('admin._nav')

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ $editing ? route('admin.casts.update', $cast->id) : route('admin.casts.store') }}" method="post">
    @csrf
    @if ($editing)
      @method('PUT')
    @endif

    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $cast->name) }}" required>
    </div>

    <div class="form-group">
      <label>Umur</label>
      <input type="number" name="age" class="form-control" value="{{ old('age', $cast->age) }}" required>
    </div>

    <div class="form-group">
      <label>Bio</label>
      <textarea name="bio" rows="4" class="form-control" required>{{ old('bio', $cast->bio) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.casts.index') }}" class="btn btn-default">Batal</a>
  </form>
</div>
@endsection