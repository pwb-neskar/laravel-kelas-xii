@extends('templates.index')

@section('content')
@php($editing = $peran->exists)
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: {{ $editing ? 'Ubah' : 'Tambah' }} Peran</h3>
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

  <form action="{{ $editing ? route('admin.perans.update', $peran->id) : route('admin.perans.store') }}" method="post">
    @csrf
    @if ($editing)
      @method('PUT')
    @endif

    <div class="form-group">
      <label>Film</label>
      <select name="film_id" class="form-control" required>
        <option value="">-- pilih film --</option>
        @foreach ($films as $f)
          <option value="{{ $f->id }}" {{ (string) old('film_id', $peran->film_id) === (string) $f->id ? 'selected' : '' }}>{{ $f->title }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Cast</label>
      <select name="cast_id" class="form-control" required>
        <option value="">-- pilih cast --</option>
        @foreach ($casts as $c)
          <option value="{{ $c->id }}" {{ (string) old('cast_id', $peran->cast_id) === (string) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Nama Peran</label>
      <input type="text" name="actor" class="form-control" value="{{ old('actor', $peran->actor) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.perans.index') }}" class="btn btn-default">Batal</a>
  </form>
</div>
@endsection