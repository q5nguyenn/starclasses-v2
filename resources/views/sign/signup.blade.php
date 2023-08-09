<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Star Classes - Signup</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('x-icon.ico') }}" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/course.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sign.css') }}">
</head>

<body>
  <div class="container-sign"></div>
  <div class="container-wrapper">
    <div class="sign-icon"><img src="{{ asset('images/sign-icon.png') }}" alt="" /></div>
    <div class="sign-pic">
      <img src="{{ asset('images/signpic.jpg') }}" alt="" />
      <div class="byword">
        <div class="byword-title">
          "The universe is full of magical things patiently waiting for our
          wits to grow sharper."
        </div>
        <div class="byword-author">- Eden Phillpotts</div>
      </div>
    </div>
    <form class="sign-box" novalidate method="post" action="{{ route('signup.submit') }}">
      @csrf
      <div class="sign-title">Sign up</div>
      <div class="input-item">
        <i class="bi bi-person"></i>
        <input type="text" class="input" placeholder="Username" id="username" name="name"
          value="{{ old('name') }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('name')
          {{ $message }}
        @enderror
      </div>
      <div class="input-item">
        <i class="bi bi-envelope"></i>
        <input type="Email" class="input" placeholder="Email" id="email" name="email"
          value="{{ old('email') }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('email')
          {{ $message }}
        @enderror
      </div>
      <div class="input-item">
        <i class="bi bi-telephone"></i>
        <input type="number" class="input" placeholder="Phone number" id="phone" name="phone_number"
          value="{{ old('phone_number') }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('phone_number')
          {{ $message }}
        @enderror
      </div>
      <div class="input-item">
        <i class="bi bi-key"></i>
        <input type="password" class="input" placeholder="Password" id="password" name="password" />
        <span class="focus-input"></span>
        <div class="show-password">
          <i class="bi bi-eye-slash"></i>
        </div>
      </div>
      <div class="input-item-error">&nbsp;
        @error('password')
          {{ $message }}
        @enderror
      </div>
      <div class="term">
        <input type="checkbox" id="term" value="yes" name="checkbox"
          {{ old('checkbox') == 'yes' ? 'checked' : '' }} /><label for="term" class="checkbox"></label>
        <span class="term-text">
          <label for="term">I agree to our </label>
          <a href="./terms.html" class="term-link">terms and conditions</a>
        </span>

      </div>
      <div class="input-item-error">&nbsp;
        @error('checkbox')
          {{ $message }}
        @enderror
      </div>
      <button class="button-fa button-signup" type="submit">Sign up</button>
      <div>or</div>
      <a href="{{ route('signin.google') }}" class="button-fa button"><i class="bi bi-google"></i> Signup with
        google</a>
      <div class="sign-more">
        Already have an account?
        <a href="{{ route('signin') }}" class="sign-more-link"> Log in</a>
      </div>
    </form>
  </div>
  {{-- <!-- Fake Loading -->
    <div class="loading">
        <a href="./index.html" class="logo logo-animation">
            <div class="logo-inner">
                <img src="./images/logo.png" alt="" />
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
    </div> --}}
  {{-- <script type="module" src="./js/user.js"></script>
    <script type="module" src="./js/signup.js"></script> --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('js/signup.js') }}"></script>
</body>

</html>
