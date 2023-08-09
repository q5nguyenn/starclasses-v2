<!DOCTYPE html>
<html>

<head>
  <style>
    .button:hover {
      color: #fff;
    }

    a:hover {
      color: #ad5df0;
    }
  </style>
</head>

<body>
  <div style="width: 600px; margin: 0 auto">
    <div class="logo logo-animation" style="display: flex">
      <div class="logo-inner" style="text-align: center; width: 100%">
        <!-- <img src="{{ asset('images/logo.png') }}" alt="" /> -->
        <img src="https://i.ibb.co/xhrfV65/logo.png" alt="" style="object-fit: cover; height: 60px; width: 60px" />
      </div>
    </div>
    <div style="margin: 30px 50px; text-align: center; font-size: 16px">
      <p style="font-weight: bold; font-size: 32px">
        Reset password
      </p>
      <p>
        A password change has been requested for your account. If this was you, please use the link below to reset your
        password.
      </p>
    </div>
    <div style="text-align: center; margin: 40px">
      <a href="{{ route('password.change', ['token' => $user->token, 'user_id' => $user->id]) }}" class="button"
        style="
                        color: #fff;
                        font-weight: bold;
                        text-decoration: none;
                        background-image: linear-gradient(
                            316deg,
                            rgb(75, 161, 252) 3%,
                            rgb(236, 42, 237) 100%
                        );
                        cursor: pointer;
                        font-size: 16px;
                        opacity: 0.8;
                        padding: 16px 25px;
                    ">Reset
        password
      </a>
    </div>
  </div>
</body>

</html>
