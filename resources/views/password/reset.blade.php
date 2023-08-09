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
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    <form class="sign-box signup" novalidate action="{{ route('password.reset') }}" method="post">
      @csrf
      <input type="hidden" name="user_id" value="{{ $user->id }}">
      <div class="sign-title">Reset password</div>
      <div>&nbsp;{{ $error ?? '' }}</div>
      <div class="input-item">
        <i class="bi bi-key-fill"></i>
        <input type="password" class="input input-password" placeholder="Password" id="password" name="password"
          value="{{ old('password') }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('password')
          {{ $message }}
        @enderror
      </div>
      <div class="input-item">
        <i class="bi bi-key"></i>
        <input type="password" class="input input-password" placeholder="Repeat password" id="password_confirmation"
          name="password_confirmation" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('password_confirmation')
          {{ $message }}
        @enderror
      </div>
      <div class="term">
        <input type="checkbox" id="checkbox1" />
        <label class="checkbox" for="checkbox1"></label>
        <label for="checkbox1">
          <span>Show password</span>
        </label>
      </div>
      <button class="button-fa" type="submit">Reset</button>
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('js/signin.js') }}"></script>
</body>

</html>
