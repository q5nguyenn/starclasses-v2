<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Star Classes - Signin</title>
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
    <form class="sign-box signup" novalidate action="{{ route('signin.submit') }}" method="post">
      @csrf
      <div class="sign-title">Log in</div>
      <div class="{{ $alert ? 'sign-title-error' : 'sign-title-error-hidden' }}">&nbsp;{!! $alert ?? '' !!}</div>
      <div class="input-item">
        <i class="bi bi-person"></i>
        <input type="email" class="input" placeholder="Email" id="email" name="email"
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
        <input type="password" class="input input-password" placeholder="Password" id="password" name="password" />
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
        <a href="{{ route('password.forgot') }}" class="forgot-pass">Forgot password?</a>
      </div>
      <button class="button-fa" type="submit">Log in</button>
      <div>or</div>
      <a href="{{ route('signin.google') }}" class="button-fa button"><i class="bi bi-google"></i> Signin with
        google</a>
      <div class="sign-more">
        Don't have an account?
        <a href="{{ route('signup') }}" class="sign-more-link">Sign up</a>
      </div>
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('js/signin.js') }}"></script>
</body>

</html>
