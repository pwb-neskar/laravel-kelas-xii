@extends('templates.index')

@section('content')
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: Cast</h3>
  @include('admin._nav')

  <a href="{{ route('admin.casts.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">+ Tambah Cast</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:50px">#</th>
        <th>Nama</th>
        <th style="width:80px">Umur</th>
        <th>Bio</th>
        <th style="width:150px">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($casts as $item)
        <tr>
          <td>{{ $casts->firstItem() + $loop->index }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->age }}</td>
          <td>{{ \Illuminate\Support\Str::limit($item->bio, 80) }}</td>
          <td>
            <a href="{{ route('admin.casts.edit', $item->id) }}" class="btn btn-xs btn-warning">Ubah</a>
            <form action="{{ route('admin.casts.destroy', $item->id) }}" method="post" style="display:inline"
                  onsubmit="return confirm('Hapus cast ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5">Belum ada cast.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $casts->links('pagination::bootstrap-3') }}
</div>
@endsection