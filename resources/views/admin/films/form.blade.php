@extends('templates.index')

@section('content')
@php($editing = $film->exists)
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: {{ $editing ? 'Ubah' : 'Tambah' }} Film</h3>
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

  <form action="{{ $editing ? route('admin.films.update', $film->id) : route('admin.films.store') }}"
        method="post" enctype="multipart/form-data">
    @csrf
    @if ($editing)
      @method('PUT')
    @endif

    <div class="form-group">
      <label>Judul</label>
      <input type="text" name="title" class="form-control" value="{{ old('title', $film->title) }}" required>
    </div>

    <div class="form-group">
      <label>Tahun</label>
      <input type="number" name="year" class="form-control" value="{{ old('year', $film->year) }}" required>
    </div>

    <div class="form-group">
      <label>Genre</label>
      <select name="genre_id" class="form-control" required>
        <option value="">-- pilih genre --</option>
        @foreach ($genres as $g)
          <option value="{{ $g->id }}" {{ (string) old('genre_id', $film->genre_id) === (string) $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Sinopsis</label>
      <textarea name="sinopsis" rows="5" class="form-control" required>{{ old('sinopsis', $film->sinopsis) }}</textarea>
    </div>

    <div class="form-group">
      <label>Poster {{ $editing ? '(kosongkan jika tidak diganti)' : '' }}</label>
      @if ($editing && $film->poster)
        <div style="margin-bottom:8px"><img src="/{{ $film->poster }}" alt="" style="height:90px"></div>
      @endif
      <input type="file" name="poster" class="form-control" accept="image/*" {{ $editing ? '' : 'required' }}>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.films.index') }}" class="btn btn-default">Batal</a>
  </form>
</div>
@endsection