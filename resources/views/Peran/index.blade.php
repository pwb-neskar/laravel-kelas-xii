<!DOCTYPE html>
<html lang="en">
<head>
    @include('templates.component.head')
    <head>
    <!-- Tambahkan CSS khusus di sini -->
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            background-color: #ff9800;
            color: #000 !important;
            font-weight: bold;
            padding: 10px;
            text-align: left;
        }
        .table td {
            padding: 10px;
            border-bottom: 1px solid #000;
            color: #000 !important;
        }

        .pagination {
    justify-content: center !important;
}

    </style>
</head>
</head>
<body>
    @include('templates.component.header')
    @include('templates.component.login')
    @include('templates.component.navbar')

    <div class="container mt-5">
        <br>
        <h1 class="text-justify mb-4">DAFTAR PERAN</h1>
        <br>
        <a href="{{ route('peran.create')}} " class="btn btn-success mb-3">Tambah Peran</a>
        <br>
        <table class="table table-striped">
            <br>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Actor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($perans as $peran)
                    <tr>
                        <td>{{ $peran->id }}</td>
                        <td>{{ $peran->actor }}</td>
                        
                        <td>
                            <a href="{{ route('peran.show', $peran->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('peran.edit', $peran->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('peran.destroy', $peran->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Centered Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $perans->links() }}
        </div>
    </div>

    @include('templates.component.footer')
</body>
</html>
