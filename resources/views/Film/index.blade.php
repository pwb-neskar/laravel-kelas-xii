<!DOCTYPE html>
<html lang="en">
<head>
    @include('templates.component.head')
</head>
<body>
    @include('templates.component.header')
    @include('templates.component.login')
    @include('templates.component.navbar')

    <div class="general_social_icons">
        <nav class="social">
            <ul>
                <li class="w3_twitter"><a href="#">Twitter <i class="fa fa-twitter"></i></a></li>
                <li class="w3_facebook"><a href="#">Facebook <i class="fa fa-facebook"></i></a></li>
                <li class="w3_dribbble"><a href="#">Dribbble <i class="fa fa-dribbble"></i></a></li>
                <li class="w3_g_plus"><a href="#">Google+ <i class="fa fa-google-plus"></i></a></li>
            </ul>
        </nav>
    </div>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Film List</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID FILM</th>
                    <th>Title</th>
                    <th>Sinopsis</th>
                    <th>Year</th>
                    <th>Genre</th>
                    <th>Actions</th> <!-- Added this header for actions -->
                </tr>
            </thead>
            <tbody>
                @foreach($films as $film)
                    <tr>
                        <td>{{ $film->id }}</td>
                        <td>{{ $film->title }}</td>
                        <td>{{ $film->sinopsis }}</td>
                        <td>{{ $film->year }}</td>
                        <td>{{ $film->genre->name ?? 'N/A' }}</td>
                        </td>
                        <td>
                            <!-- Example actions; adjust as needed -->
                            <a href="{{ route('film.show', $film->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('film.edit', $film->id) }}" class="btn btn-warning btn-sm">Edit</a>
                             <form action="{{ route('film.destroy', $film->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm">DELETE</button>
                                </form>
                        </td>
                    </tr>
                @endforeach

                <!-- Example of an additional row below existing data -->
                <tr>
                    <td colspan="7" class="text-center">No more films to display</td> <!-- Adjust colspan to match the number of columns -->
                </tr>
            </tbody>
        </table>
    </div>

    @include('templates.component.footer')
</body>
</html>