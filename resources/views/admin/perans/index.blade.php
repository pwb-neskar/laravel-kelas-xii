@extends('admin.layouts.app')
@section('title', 'Data Peran')

@section('content')
<div class="clearfix">
  <h2 class="pull-left" style="margin-top:0">Data Peran</h2>
  <a href="{{ route('admin.perans.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Peran</a>
</div>

<form method="GET" class="form-inline" style="margin-bottom:15px">
  <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari peran...">
  <button class="btn btn-default"><i class="fa fa-search"></i></button>
</form>

<div class="panel panel-default">
  <table class="table table-striped table-hover">
    <thead><tr><th>#</th><th>Film</th><th>Cast</th><th>Peran</th><th width="130">Aksi</th></tr></thead>
    <tbody>
    @forelse ($perans as $peran)
      <tr>
        <td>{{ $perans->firstItem() + $loop->index }}</td>
        <td>{{ $peran->film->title ?? '-' }}</td>
        <td>{{ $peran->cast->name ?? '-' }}</td>
        <td>{{ $peran->actor }}</td>
        <td>
          <a href="{{ route('admin.perans.edit', $peran) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
          <form action="{{ route('admin.perans.destroy', $peran) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus peran ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
{{ $perans->links() }}
@endsection
