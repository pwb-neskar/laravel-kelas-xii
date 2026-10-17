@extends('admin.layouts.app')
@section('title', 'Data User')

@section('content')
<div class="clearfix">
  <h2 class="pull-left" style="margin-top:0">Data User</h2>
  <a href="{{ route('admin.users.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah User</a>
</div>

<form method="GET" class="form-inline" style="margin-bottom:15px">
  <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / email...">
  <button class="btn btn-default"><i class="fa fa-search"></i></button>
</form>

<div class="panel panel-default">
  <table class="table table-striped table-hover">
    <thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Role</th><th width="130">Aksi</th></tr></thead>
    <tbody>
    @forelse ($users as $user)
      <tr>
        <td>{{ $users->firstItem() + $loop->index }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td><span class="label label-{{ $user->role?->name === 'admin' ? 'danger' : 'default' }}">{{ $user->role->name ?? '-' }}</span></td>
        <td>
          <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
          @if ($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus user ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
          </form>
          @endif
        </td>
      </tr>
    @empty
      <tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
{{ $users->links() }}
@endsection
