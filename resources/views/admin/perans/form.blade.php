@extends('admin.layouts.app')
@section('title', $peran->exists ? 'Edit Peran' : 'Tambah Peran')

@section('content')
<h2 style="margin-top:0">{{ $peran->exists ? 'Edit Peran' : 'Tambah Peran' }}</h2>

<div class="panel panel-default"><div class="panel-body">
<form action="{{ $peran->exists ? route('admin.perans.update', $peran) : route('admin.perans.store') }}" method="POST">
  @csrf
  @if ($peran->exists) @method('PUT') @endif

  <div class="form-group @error('film_id') has-error @enderror">
    <label>Film</label>
    <select name="film_id" class="form-control">
      <option value="">-- pilih film --</option>
      @foreach ($films as $opt)
        <option value="{{ $opt->id }}" {{ old('film_id', $peran->film_id) == $opt->id ? 'selected' : '' }}>{{ $opt->title }}</option>
      @endforeach
    </select>
    @error('film_id') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('cast_id') has-error @enderror">
    <label>Cast (pemain)</label>
    <select name="cast_id" class="form-control">
      <option value="">-- pilih cast --</option>
      @foreach ($casts as $opt)
        <option value="{{ $opt->id }}" {{ old('cast_id', $peran->cast_id) == $opt->id ? 'selected' : '' }}>{{ $opt->name }}</option>
      @endforeach
    </select>
    @error('cast_id') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('actor') has-error @enderror">
    <label>Nama Peran</label>
    <input type="text" name="actor" class="form-control" value="{{ old('actor', $peran->actor) }}">
    @error('actor') <span class="help-block">{{ $message }}</span> @enderror
  </div>

  <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
  <a href="{{ route('admin.perans.index') }}" class="btn btn-default">Batal</a>
</form>
</div></div>
@endsection
