@extends('admin.layouts.app')
@section('title', 'Data Cast')

@section('content')
<div class="clearfix">
  <h2 class="pull-left" style="margin-top:0">Data Cast</h2>
  <a href="{{ route('admin.casts.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Cast</a>
</div>

<form method="GET" class="form-inline" style="margin-bottom:15px">
  <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama...">
  <button class="btn btn-default"><i class="fa fa-search"></i></button>
</form>

<div class="panel panel-default">
  <table class="table table-striped table-hover">
    <thead><tr><th>#</th><th>Nama</th><th>Umur</th><th>Bio</th><th>Jml Peran</th><th width="130">Aksi</th></tr></thead>
    <tbody>
    @forelse ($casts as $cast)
      <tr>
        <td>{{ $casts->firstItem() + $loop->index }}</td>
        <td>{{ $cast->name }}</td>
        <td>{{ $cast->age }}</td>
        <td>{{ \Illuminate\Support\Str::limit($cast->bio, 50) }}</td>
        <td>{{ $cast->perans_count }}</td>
        <td>
          <a href="{{ route('admin.casts.edit', $cast) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
          <form action="{{ route('admin.casts.destroy', $cast) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus cast ini beserta perannya?')">
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
{{ $casts->links() }}
@endsection
