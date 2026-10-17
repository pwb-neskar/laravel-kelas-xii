<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') - {{ config('app.name') }} Admin</title>
  <link href="{{ asset('template/css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('template/css/font-awesome.min.css') }}" rel="stylesheet">
  <style>
    body { background: #f4f6f9; padding-top: 50px; }
    .sidebar { position: fixed; top: 50px; bottom: 0; left: 0; width: 220px; background: #222d32; padding-top: 10px; overflow-y: auto; }
    .sidebar a { display: block; color: #b8c7ce; padding: 12px 20px; text-decoration: none; }
    .sidebar a:hover, .sidebar a.active { background: #1e282c; color: #fff; border-left: 3px solid #3c8dbc; }
    .sidebar a .fa { width: 22px; }
    .content { margin-left: 220px; padding: 25px; }
    .stat-card { border-radius: 4px; color: #fff; padding: 18px 20px; margin-bottom: 20px; display: block; }
    .stat-card:hover { color: #fff; text-decoration: none; opacity: .9; }
    .stat-card .num { font-size: 32px; font-weight: bold; }
    .stat-card .fa { font-size: 44px; opacity: .35; float: right; margin-top: 6px; }
    .bg-primary-c { background: #3c8dbc; } .bg-success-c { background: #00a65a; } .bg-info-c { background: #00c0ef; }
    .bg-warning-c { background: #f39c12; } .bg-danger-c { background: #dd4b39; } .bg-default-c { background: #605ca8; }
    .poster-thumb { width: 45px; height: 62px; object-fit: cover; border-radius: 3px; }
    .table > tbody > tr > td { vertical-align: middle; }
    .navbar-inverse { margin-bottom: 0; }
    @media (max-width: 767px) { .sidebar { position: static; width: 100%; } .content { margin-left: 0; } body { padding-top: 0; } }
  </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><i class="fa fa-film"></i> {{ config('app.name') }} Admin</a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="{{ route('home') }}" target="_blank"><i class="fa fa-external-link"></i> Lihat Website</a></li>
      <li><a href="#"><i class="fa fa-user"></i> {{ auth()->user()->name }}</a></li>
      <li>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
      </li>
    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
  </div>
</nav>

<div class="sidebar">
  @php
    $menu = [
      ['admin.dashboard',     'fa-dashboard', 'Dashboard',  'admin.dashboard'],
      ['admin.films.index',   'fa-film',      'Film',       'admin.films.*'],
      ['admin.genres.index',  'fa-tags',      'Genre',      'admin.genres.*'],
      ['admin.casts.index',   'fa-users',     'Cast',       'admin.casts.*'],
      ['admin.perans.index',  'fa-id-badge',  'Peran',      'admin.perans.*'],
      ['admin.kritiks.index', 'fa-comments',  'Kritik',     'admin.kritiks.*'],
      ['admin.users.index',   'fa-user',      'User',       'admin.users.*'],
    ];
  @endphp
  @foreach ($menu as [$route, $icon, $label, $pattern])
    <a href="{{ route($route) }}" class="{{ request()->routeIs($pattern) ? 'active' : '' }}">
      <i class="fa {{ $icon }}"></i> {{ $label }}
    </a>
  @endforeach
</div>

<div class="content">
  @if (session('success'))
    <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('error') }}</div>
  @endif

  @yield('content')
</div>

<script src="{{ asset('template/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
@stack('scripts')
</body>
</html>
