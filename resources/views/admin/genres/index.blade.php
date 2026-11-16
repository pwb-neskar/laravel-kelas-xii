@extends('templates.index')

@section('content')
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: Genre</h3>
  @include('admin._nav')

  <a href="{{ route('admin.genres.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">+ Tambah Genre</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:50px">#</th>
        <th>Nama Genre</th>
        <th style="width:150px">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($genres as $item)
        <tr>
          <td>{{ $genres->firstItem() + $loop->index }}</td>
          <td>{{ $item->name }}</td>
          <td>
            <a href="{{ route('admin.genres.edit', $item->id) }}" class="btn btn-xs btn-warning">Ubah</a>
            <form action="{{ route('admin.genres.destroy', $item->id) }}" method="post" style="display:inline"
                  onsubmit="return confirm('Hapus genre ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="3">Belum ada genre.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $genres->links('pagination::bootstrap-3') }}
</div>
@endsection