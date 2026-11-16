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

              {{-- FORM LOGIN --}}
              <div class="form">
              <h3>Login to your account</h3>
              <form action="{{ route('login.attempt') }}" method="post">
                @csrf
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                <input type="password" name="password" placeholder="Password" required>
                @error('email')
                  <p style="color:red">{{ $message }}</p>
                @enderror
                <input type="submit" value="Login">
              </form>
              </div>

              {{-- FORM REGISTER --}}
              <div class="form">
              <h3>Create an account</h3>
              <form action="{{ route('register.attempt') }}" method="post">
                @csrf
                <input type="hidden" name="form_type" value="register">
                <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}" required>
                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                <input type="password" name="password" placeholder="Password (min. 8 karakter)" required>
                <input type="password" name="password_confirmation" placeholder="Ulangi Password" required>
                @foreach ($errors->register->all() as $message)
                  <p style="color:red">{{ $message }}</p>
                @endforeach
                <input type="submit" value="Register">
              </form>
              </div>

              <div class="cta"><a href="#">Forgot your password?</a></div>
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

{{-- Buka modal otomatis kalau login/register gagal --}}
@if (session('openLogin') || $errors->any() || $errors->register->any())
<script>
  $(function () {
    $('#myModal').one('shown.bs.modal', function () {
      @if (old('form_type') === 'register')
        // error register: tampilkan form register
        $('.toggle').trigger('click');
      @endif
    });
    $('#myModal').modal('show');
  });
</script>
@endif