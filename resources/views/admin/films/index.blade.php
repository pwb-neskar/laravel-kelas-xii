@extends('admin.layouts.app')
@section('title', 'Data Film')

@section('content')
<div class="clearfix">
  <h2 class="pull-left" style="margin-top:0">Data Film</h2>
  <a href="{{ route('admin.films.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Film</a>
</div>

<form method="GET" class="form-inline" style="margin-bottom:15px">
  <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul...">
  <button class="btn btn-default"><i class="fa fa-search"></i></button>
</form>

<div class="panel panel-default">
  <table class="table table-striped table-hover">
    <thead><tr><th>#</th><th>Poster</th><th>Judul</th><th>Tahun</th><th>Genre</th><th width="130">Aksi</th></tr></thead>
    <tbody>
    @forelse ($films as $film)
      <tr>
        <td>{{ $films->firstItem() + $loop->index }}</td>
        <td><img src="{{ $film->poster_url }}" class="poster-thumb" alt=""></td>
        <td>{{ $film->title }}</td>
        <td>{{ $film->year }}</td>
        <td>{{ $film->genre->name ?? '-' }}</td>
        <td>
          <a href="{{ route('admin.films.edit', $film) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
          <form action="{{ route('admin.films.destroy', $film) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus film ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="6" class="text-center text-muted">Tidak ada data.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
{{ $films->links() }}
@endsection
