@extends('templates.index')

@section('content')
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: Daftar User</h3>
  @include('admin._nav')

  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:50px">#</th>
        <th>Nama</th>
        <th>Email</th>
        <th style="width:120px">Role</th>
        <th style="width:160px">Terdaftar</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($users as $item)
        <tr>
          <td>{{ $users->firstItem() + $loop->index }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->email }}</td>
          <td>{{ $item->role_name }}</td>
          <td>{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</td>
        </tr>
      @empty
        <tr><td colspan="5">Belum ada user.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $users->links('pagination::bootstrap-3') }}
</div>
@endsection