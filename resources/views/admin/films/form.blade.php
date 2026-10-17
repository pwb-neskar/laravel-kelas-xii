@extends('admin.layouts.app')
@section('title', $film->exists ? 'Edit Film' : 'Tambah Film')

@section('content')
<h2 style="margin-top:0">{{ $film->exists ? 'Edit Film' : 'Tambah Film' }}</h2>

<div class="panel panel-default"><div class="panel-body">
<form action="{{ $film->exists ? route('admin.films.update', $film) : route('admin.films.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  @if ($film->exists) @method('PUT') @endif

  <div class="form-group @error('title') has-error @enderror">
    <label>Judul</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $film->title) }}">
    @error('title') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="row">
    <div class="col-sm-6">
  <div class="form-group @error('year') has-error @enderror">
    <label>Tahun</label>
    <input type="number" name="year" class="form-control" value="{{ old('year', $film->year) }}">
    @error('year') <span class="help-block">{{ $message }}</span> @enderror
  </div>
    </div>
    <div class="col-sm-6">
  <div class="form-group @error('genre_id') has-error @enderror">
    <label>Genre</label>
    <select name="genre_id" class="form-control">
      <option value="">-- pilih genre --</option>
      @foreach ($genres as $opt)
        <option value="{{ $opt->id }}" {{ old('genre_id', $film->genre_id) == $opt->id ? 'selected' : '' }}>{{ $opt->name }}</option>
      @endforeach
    </select>
    @error('genre_id') <span class="help-block">{{ $message }}</span> @enderror
  </div>
    </div>
  </div>
  <div class="form-group @error('sinopsis') has-error @enderror">
    <label>Sinopsis</label>
    <textarea name="sinopsis" rows="5" class="form-control">{{ old('sinopsis', $film->sinopsis) }}</textarea>
    @error('sinopsis') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('poster') has-error @enderror">
    <label>Poster {{ $film->exists ? '(kosongkan jika tidak diganti)' : '' }}</label>
    @if ($film->exists)
      <div style="margin-bottom:8px"><img src="{{ $film->poster_url }}" style="height:140px" alt=""></div>
    @endif
    <input type="file" name="poster" accept="image/*">
    <p class="help-block">jpg / png / webp, maksimal 2 MB. Disimpan di <code>storage/app/public/images</code>.</p>
    @error('poster') <span class="help-block">{{ $message }}</span> @enderror
  </div>

  <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
  <a href="{{ route('admin.films.index') }}" class="btn btn-default">Batal</a>
</form>
</div></div>
@endsection
