<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Star Classes - Forgot password</title>
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
    <form class="sign-box" novalidate method="post" action="{{ route('password.send') }}">
      @csrf
      <div class="sign-title">Forgot Password</div>
      <div style="margin-bottom: 20px">
        Enter your registered <b>email address</b>, we will help you recover
        your password
      </div>
      <div class="input-item">
        <i class="bi bi-envelope"></i>
        <input type="email" class="input" placeholder="Email" id="email" name="email"
          value="{{ old('email') }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('email')
          {{ $message }}
        @enderror
      </div>
      <button class="button-fa button-signup" type="submit">
        Reset password
      </button>
      <div class="sign-more">
        Or
        <a href="{{ route('signin') }}" class="sign-more-link"> Log in</a>
      </div>
    </form>
  </div>
  <div class="popup-repassword">
    <div class="popup-repassword-wrapper">
      <div class="popup-repassword-img">
        <img src="./images/unread.png" alt="" />
      </div>
      <div class="popup-repassword-content">
        <b>Check email for reset link</b> <br />
        An email has been sent to your email.<br />
        Check the inbox of your email, and Click the reset link provided.
      </div>
    </div>
  </div>
</body>

</html>
