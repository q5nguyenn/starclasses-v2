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
        You have successfully purchased the course
      </p>
      <p>
        <a href="{{ route('index') }}"
          style="
                            color: #ad5df0;
                            font-weight: bold;
                            text-decoration: none;
                        ">English
          cho người đi làm</a>
      </p>
    </div>
    <div style="text-align: center; margin: 40px">

    </div>
    <div style="text-align: center; font-size: 13px">
      Now you can study the above courses, the course progress will be displayed in My learning in Your profile
    </div>
  </div>
</body>

</html>
