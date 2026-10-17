@extends('admin.layouts.app')
@section('title', $kritik->exists ? 'Edit Kritik' : 'Tambah Kritik')

@section('content')
<h2 style="margin-top:0">{{ $kritik->exists ? 'Edit Kritik' : 'Tambah Kritik' }}</h2>

<div class="panel panel-default"><div class="panel-body">
<form action="{{ $kritik->exists ? route('admin.kritiks.update', $kritik) : route('admin.kritiks.store') }}" method="POST">
  @csrf
  @if ($kritik->exists) @method('PUT') @endif

  <div class="form-group @error('film_id') has-error @enderror">
    <label>Film</label>
    <select name="film_id" class="form-control">
      <option value="">-- pilih film --</option>
      @foreach ($films as $opt)
        <option value="{{ $opt->id }}" {{ old('film_id', $kritik->film_id) == $opt->id ? 'selected' : '' }}>{{ $opt->title }}</option>
      @endforeach
    </select>
    @error('film_id') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('user_id') has-error @enderror">
    <label>User</label>
    <select name="user_id" class="form-control">
      <option value="">-- pilih user --</option>
      @foreach ($users as $opt)
        <option value="{{ $opt->id }}" {{ old('user_id', $kritik->user_id) == $opt->id ? 'selected' : '' }}>{{ $opt->name }}</option>
      @endforeach
    </select>
    @error('user_id') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('rating') has-error @enderror">
    <label>Rating</label>
    <select name="rating" class="form-control">
      @for ($i = 1; $i <= 5; $i++)
        <option value="{{ $i }}" {{ old('rating', $kritik->rating) == $i ? 'selected' : '' }}>{{ $i }}</option>
      @endfor
    </select>
    @error('rating') <span class="help-block">{{ $message }}</span> @enderror
  </div>
  <div class="form-group @error('comment') has-error @enderror">
    <label>Komentar</label>
    <textarea name="comment" rows="4" class="form-control">{{ old('comment', $kritik->comment) }}</textarea>
    @error('comment') <span class="help-block">{{ $message }}</span> @enderror
  </div>

  <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
  <a href="{{ route('admin.kritiks.index') }}" class="btn btn-default">Batal</a>
</form>
</div></div>
@endsection
