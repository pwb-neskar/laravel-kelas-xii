<div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Sign In & Sign Up
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
      </div>
      <section>
        <div class="modal-body">
          <div class="w3_login_module">
            <div class="module form-module">
              <div class="toggle"><i class="fa fa-times fa-pencil"></i>
              <div class="tooltip">Click Me</div>
              </div>
              <div class="form">
              <h3>Login to your account</h3>
              @if ($errors->login->any())
                <div class="alert alert-danger" style="padding:8px;margin-bottom:10px">{{ $errors->login->first() }}</div>
              @elseif (session('open_login'))
                <div class="alert alert-info" style="padding:8px;margin-bottom:10px">Silakan login terlebih dahulu.</div>
              @endif
              <form action="{{ route('login.post') }}" method="post">
                @csrf
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <input type="submit" value="Login">
              </form>
              </div>
              <div class="form">
              <h3>Create an account</h3>
              @if ($errors->register->any())
                <div class="alert alert-danger" style="padding:8px;margin-bottom:10px">
                  @foreach ($errors->register->all() as $error)
                    <div>{{ $error }}</div>
                  @endforeach
                </div>
              @endif
              <form action="{{ route('register.post') }}" method="post">
                @csrf
                <input type="text" name="name" placeholder="Nama" required="">
                <input type="email" name="email" placeholder="Email Address" required="">
                <input type="password" name="password" placeholder="Password (min. 8 karakter)" required="">
                <input type="password" name="password_confirmation" placeholder="Ulangi Password" required="">
                <input type="submit" value="Register">
              </form>
              </div>
              
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<script>
  $('.toggle').click(function(){
    // Switches the Icon
    $(this).children('i').toggleClass('fa-pencil');
    // Switches the forms  
    $('.form').animate({
    height: "toggle",
    'padding-top': 'toggle',
    'padding-bottom': 'toggle',
    opacity: "toggle"
    }, "slow");
  });
</script>