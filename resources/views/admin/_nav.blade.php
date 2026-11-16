<ul class="nav nav-pills" style="margin-bottom: 20px;">
  <li class="{{ request()->routeIs('admin.films.*') ? 'active' : '' }}"><a href="{{ route('admin.films.index') }}">Film</a></li>
  <li class="{{ request()->routeIs('admin.casts.*') ? 'active' : '' }}"><a href="{{ route('admin.casts.index') }}">Cast</a></li>
  <li class="{{ request()->routeIs('admin.genres.*') ? 'active' : '' }}"><a href="{{ route('admin.genres.index') }}">Genre</a></li>
  <li class="{{ request()->routeIs('admin.perans.*') ? 'active' : '' }}"><a href="{{ route('admin.perans.index') }}">Peran</a></li>
  <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}">Daftar User</a></li>
</ul>

@if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif