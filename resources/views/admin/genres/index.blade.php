@extends('admin.layouts.app')
@section('title', 'Data Genre')

@section('content')
<div class="clearfix">
  <h2 class="pull-left" style="margin-top:0">Data Genre</h2>
  <a href="{{ route('admin.genres.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Genre</a>
</div>

<form method="GET" class="form-inline" style="margin-bottom:15px">
  <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari genre...">
  <button class="btn btn-default"><i class="fa fa-search"></i></button>
</form>

<div class="panel panel-default">
  <table class="table table-striped table-hover">
    <thead><tr><th>#</th><th>Nama</th><th>Jumlah Film</th><th width="130">Aksi</th></tr></thead>
    <tbody>
    @forelse ($genres as $genre)
      <tr>
        <td>{{ $genres->firstItem() + $loop->index }}</td>
        <td>{{ $genre->name }}</td>
        <td>{{ $genre->films_count }}</td>
        <td>
          <a href="{{ route('admin.genres.edit', $genre) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
          <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus genre ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
{{ $genres->links() }}
@endsection
