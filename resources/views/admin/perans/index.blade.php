@extends('templates.index')

@section('content')
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: Peran</h3>
  @include('admin._nav')

  <a href="{{ route('admin.perans.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">+ Tambah Peran</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:50px">#</th>
        <th>Film</th>
        <th>Cast</th>
        <th>Peran</th>
        <th style="width:150px">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($perans as $item)
        <tr>
          <td>{{ $perans->firstItem() + $loop->index }}</td>
          <td>{{ $item->film_title }}</td>
          <td>{{ $item->cast_name }}</td>
          <td>{{ $item->actor }}</td>
          <td>
            <a href="{{ route('admin.perans.edit', $item->id) }}" class="btn btn-xs btn-warning">Ubah</a>
            <form action="{{ route('admin.perans.destroy', $item->id) }}" method="post" style="display:inline"
                  onsubmit="return confirm('Hapus peran ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5">Belum ada peran.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $perans->links('pagination::bootstrap-3') }}
</div>
@endsection