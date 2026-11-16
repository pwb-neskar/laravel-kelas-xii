<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="#" method="post">
        <input type="text" name="Search" placeholder="Search" required="">
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        @auth
          @if (auth()->user()->hasRole('admin'))
            <li><a href="{{ route('admin.films.index') }}">Admin: {{ auth()->user()->name }}</a></li>
          @elseif (auth()->user()->hasRole('user'))
            <li><a href="{{ route('profile.show') }}">Halo, {{ auth()->user()->name }}</a></li>
          @else
            <li><a href="#">Halo, {{ auth()->user()->name }}</a></li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="post" style="display:inline">
              @csrf
              <button type="submit" style="background:none;border:0;color:inherit;cursor:pointer">Logout</button>
            </form>
          </li>
        @else
          <li><a href="#" data-toggle="modal" data-target="#myModal">Login</a></li>
        @endauth
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>