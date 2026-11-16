@extends('templates.index')

@section('content')
@php($editing = $genre->exists)
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: {{ $editing ? 'Ubah' : 'Tambah' }} Genre</h3>
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

  <form action="{{ $editing ? route('admin.genres.update', $genre->id) : route('admin.genres.store') }}" method="post">
    @csrf
    @if ($editing)
      @method('PUT')
    @endif

    <div class="form-group">
      <label>Nama Genre</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $genre->name) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.genres.index') }}" class="btn btn-default">Batal</a>
  </form>
</div>
@endsection