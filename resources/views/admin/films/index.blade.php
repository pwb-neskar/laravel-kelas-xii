@extends('templates.index')

@section('content')
<div class="container" style="padding: 30px 0;">
  <h3>Panel Admin: Film</h3>
  @include('admin._nav')

  <a href="{{ route('admin.films.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">+ Tambah Film</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:50px">#</th>
        <th style="width:90px">Poster</th>
        <th>Judul</th>
        <th style="width:80px">Tahun</th>
        <th>Genre</th>
        <th style="width:150px">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($films as $item)
        <tr>
          <td>{{ $films->firstItem() + $loop->index }}</td>
          <td><img src="/{{ $item->poster }}" alt="" style="height:60px"></td>
          <td>{{ $item->title }}</td>
          <td>{{ $item->year }}</td>
          <td>{{ $item->genre_name }}</td>
          <td>
            <a href="{{ route('admin.films.edit', $item->id) }}" class="btn btn-xs btn-warning">Ubah</a>
            <form action="{{ route('admin.films.destroy', $item->id) }}" method="post" style="display:inline"
                  onsubmit="return confirm('Hapus film ini beserta peran dan kritiknya?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">Belum ada film.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $films->links('pagination::bootstrap-3') }}
</div>
@endsection