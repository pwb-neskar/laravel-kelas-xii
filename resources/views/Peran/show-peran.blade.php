<!DOCTYPE html>
<html lang="en">

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
    </style>
</head>

<body>
    <!-- header -->
    @include('templates.component.header')
    <!-- //header -->
    <!-- bootstrap-pop-up -->
    @include('templates.component.login')
    <!-- //bootstrap-pop-up -->
    <!-- nav -->
    @include('templates.component.navbar')
    <!-- //nav -->
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
        <br>
        <h1 class="text-center mb-4">Detail Peran</h1>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Peran</th>
                    <th>Cast ID</th>
                    <th>Film ID</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $perans->actor }}</td>
                    <td>{{ $perans->cast->name }}</td>
                    <td>{{ $perans->film_id }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @include('templates.component.footer')
</body>
</html>
