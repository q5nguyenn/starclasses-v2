<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @yield('title')
  <link rel="icon" type="image/x-icon" href="{{ asset('x-icon.ico') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin/search.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin/profile.css') }}" />
  @yield('css')
</head>

<body>
  <div class="">
    <!-- nav - bar - start -->
    @include('admin.layouts.header')
    <!-- nav - bar - end -->
    <!-- main - start -->
    <main>
      <div class="search-wrapper">
        @include('admin.layouts.nav_left')
        @yield('content')
      </div>
    </main>
    <!-- Search box hiển thị kết quả tìm kiếm -->
    <div class="search-result-popup">
      <a class="search-result-item-popup" href="#"></a>
    </div>
    <!-- main - end -->
    @include('admin.layouts.footer')
  </div>
  <script>
    var route_search = "{{ route('admin.search.popup') }}";
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('js/admin/search.js') }}"></script>
  @yield('js')
</body>

</html>
