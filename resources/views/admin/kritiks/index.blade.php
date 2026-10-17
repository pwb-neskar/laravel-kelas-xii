@extends('admin.layouts.app')
@section('title', 'Data Kritik')

@section('content')
<div class="clearfix">
  <h2 class="pull-left" style="margin-top:0">Data Kritik</h2>
  <a href="{{ route('admin.kritiks.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Kritik</a>
</div>

<form method="GET" class="form-inline" style="margin-bottom:15px">
  <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari komentar...">
  <button class="btn btn-default"><i class="fa fa-search"></i></button>
</form>

<div class="panel panel-default">
  <table class="table table-striped table-hover">
    <thead><tr><th>#</th><th>Film</th><th>User</th><th>Rating</th><th>Komentar</th><th width="130">Aksi</th></tr></thead>
    <tbody>
    @forelse ($kritiks as $kritik)
      <tr>
        <td>{{ $kritiks->firstItem() + $loop->index }}</td>
        <td>{{ $kritik->film->title ?? '-' }}</td>
        <td>{{ $kritik->user->name ?? '-' }}</td>
        <td>{{ $kritik->rating }}/5</td>
        <td>{{ \Illuminate\Support\Str::limit($kritik->comment, 60) }}</td>
        <td>
          <a href="{{ route('admin.kritiks.edit', $kritik) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
          <form action="{{ route('admin.kritiks.destroy', $kritik) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus kritik ini?')">
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
{{ $kritiks->links() }}
@endsection
