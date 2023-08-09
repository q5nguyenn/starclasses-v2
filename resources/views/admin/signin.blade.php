<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Star Classes - Sign in</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('x-icon.ico') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin/sign.css') }}" />
</head>

<body>
  <div class="container-sign"></div>
  <div class="container-wrapper">
    <div class="sign-icon"><img src="{{ asset('images/sign-icon.png') }}" alt="" /></div>
    <div class="sign-pic">
      <img src="{{ asset('images/signpic.jpg') }}" alt="" />
      <div class="byword">
        <div class="byword-title">
          "The universe is full of magical things patiently waiting for our wits to grow sharper."
        </div>
        <div class="byword-author">- Eden Phillpotts</div>
      </div>
    </div>
    <form class="sign-box signup" action="{{ route('admin.signin') }}" method="post" novalidate>
      @csrf
      <div class="sign-title">Log in</div>
      <div class="input-item">
        <i class="bi bi-person"></i>
        <input type="email" class="input" placeholder="Email" id="username" name="email"
          value="{{ old('email') }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('email')
          {{ $message }}
        @enderror
      </div>
      <div class="input-item">
        <i class="bi bi-key"></i>
        <input type="password" class="input" placeholder="Password" id="password" name="password"
          value="{{ old('password') }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('password')
          {{ $message }}
        @enderror
      </div>
      <div class="term">
        <input type="checkbox" id="checkbox1" />
        <label class="checkbox" for="checkbox1"></label>
        <label for="checkbox1">
          <span>Show password</span>
        </label>
        {{-- <a href="./forgot-password.html" class="forgot-pass"
            >Forgot password?</a
          > --}}
      </div>
      <button class="button-fa" type="submit" style="margin-top:25px">Log in</button>
      {{-- <div class="sign-more">
          Don't have an account?
          <a href="./signup.html" class="sign-more-link">Sign up</a>
        </div> --}}
    </form>
  </div>
  <!-- Fake Loading -->
  <div class="loading">
    <a href="./index.html" class="logo logo-animation">
      <div class="logo-inner">
        <img src="{{ asset('images/logo.png') }}" alt="" />
      </div>
      <div class="logo-title">Star Classes</div>
    </a>
    <div>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  {{-- <script type="module" src="./js/user.js"></script>
    <script type="module" src="./js/signin.js"></script> --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('[for="checkbox1"]').click(togglePassword);

      function togglePassword() {
        if ($('#checkbox1').is(":checked")) {
          $('#checkbox1').prop(false);
          $('#password').attr("type", "password");
        } else {
          $('#checkbox1').prop(true);
          $('#password').attr("type", "text");
        }
      }
    });
  </script>
</body>

</html>
