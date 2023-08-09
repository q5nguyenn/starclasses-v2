<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Starclasses.edu.vn - 401</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('x-icon.ico') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
  {{-- <link rel="stylesheet" href="{{ 'css/style.css' }}"> --}}
  <style>
    a {
      text-decoration: none;
      color: unset;
    }

    .footer-subtle {
      width: 100%;
      text-align: center;
      padding: 10px;
    }

    .footer-subtitle-links {
      display: flex;
      justify-content: center;
    }

    .footer-subtitle-link:hover {
      transition: 0.3s;
      background-image: linear-gradient(316deg,
          rgb(75, 161, 252) 3%,
          rgb(236, 42, 237) 100%);
      ;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  </style>
</head>

<body>
  <div class="vh-100 mx-auto container d-flex flex-column justify-content-between">
    <div class="text-center w-100 py-3">
      <img src="{{ asset('images/logo.png') }}" alt="" style="object-fit: cover; height: 60px; width: 60px" />
    </div>
    <div class="p-3 d-flex flex-column">
      <div class="text-center" style="font-size: 50px; color: #ff5a83">
        <i class="bi bi-x-circle"></i>
      </div>
      <div class="text-center py-3">
        <p class="fs-4">
          {{ $alert }}
        </p>
        <p>
          {{ $content }}
        </p>
      </div>
    </div>
    <div class="footer-subtle flex-shrink-1">
      <span>© 2023 copyright, q5nguyenn@gmail.com®</span>
      <div class="footer-subtitle-links">
        <a href="{{ route('term') }}" class="footer-subtitle-link">Privacy</a>
        |
        <a href="{{ route('term') }}" class="footer-subtitle-link">Terms Of Services</a>
      </div>
    </div>
  </div>
</body>

</html>
