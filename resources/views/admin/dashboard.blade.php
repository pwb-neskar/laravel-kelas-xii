@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<h2 style="margin-top:0">Dashboard</h2>
<p class="text-muted">Selamat datang, {{ auth()->user()->name }}.</p>

<div class="row">
  @foreach ($stats as $label => $stat)
    <div class="col-md-2 col-sm-4 col-xs-6">
      <a href="{{ route($stat['route']) }}" class="stat-card bg-{{ $stat['color'] }}-c">
        <i class="fa {{ $stat['icon'] }}"></i>
        <div class="num">{{ $stat['total'] }}</div>
        <div>{{ $label }}</div>
      </a>
    </div>
  @endforeach
</div>

<div class="row">
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading"><strong>Film terbaru</strong> <a href="{{ route('admin.films.create') }}" class="btn btn-xs btn-primary pull-right">+ Tambah</a></div>
      <table class="table table-striped">
        <thead><tr><th>Poster</th><th>Judul</th><th>Tahun</th><th>Genre</th></tr></thead>
        <tbody>
        @forelse ($latestFilms as $film)
          <tr>
            <td><img src="{{ $film->poster_url }}" class="poster-thumb" alt=""></td>
            <td>{{ $film->title }}</td>
            <td>{{ $film->year }}</td>
            <td>{{ $film->genre->name ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">Belum ada film.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading"><strong>Kritik terbaru</strong></div>
      <table class="table table-striped">
        <thead><tr><th>User</th><th>Film</th><th>Rating</th><th>Komentar</th></tr></thead>
        <tbody>
        @forelse ($latestKritiks as $kritik)
          <tr>
            <td>{{ $kritik->user->name ?? '-' }}</td>
            <td>{{ $kritik->film->title ?? '-' }}</td>
            <td>{{ $kritik->rating }}/5</td>
            <td>{{ \Illuminate\Support\Str::limit($kritik->comment, 60) }}</td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">Belum ada kritik.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading"><strong>Jumlah film per genre</strong></div>
      <table class="table table-condensed">
        <tbody>
        @foreach ($genres as $genre)
          <tr><td>{{ $genre->name }}</td><td class="text-right"><span class="badge">{{ $genre->films_count }}</span></td></tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
