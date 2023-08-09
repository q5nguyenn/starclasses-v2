<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @yield('title')
  <link rel="icon" type="image/x-icon" href="{{ asset('x-icon.ico') }}" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/boxchat.css') }}">
  @yield('css')
</head>

<body>
  <div class="container">
    @include('layouts.header')
    @yield('main')
    <!-- Search box hiển thị kết quả tìm kiếm -->
    <div class="search-result-popup">
      <a class="search-result-item-popup" href="#"></a>
    </div>
    <!-- Chat with employee -->
    {{-- <div class="chat-icon">
      <i class="bi bi-chat-fill"></i>
    </div> --}}
    <div class="box-chat box-hide">
      <div class="box-chat-top">
        <a href="{{ route('index') }}" class="logo logo-animation">
          <div class="logo-inner">
            <img src="{{ asset('images/logo.png') }}" alt="" />
          </div>
          <span class="logo-title">Star Classes</span>
        </a>
        <span class="box-minimize"><i class="bi bi-dash-lg"></i></span>
      </div>
      <div class="box-chat-content">
        <div class="box-chat-content-intro">
          <div class="box-chat-title">Chat with Star Classes</div>
          <div class="box-chat-desc">Welcome to Star Classes</div>
          <div>We're here to support you!</div>
        </div>
      </div>
      <!-- <div class="box-chat-content"></div> -->
      <form class="guest-input" data-url="{{ route('conversation.massage.create') }}" action="#" autocomplete="off">
        <div class="guest-input-item">
          <input type="text" name="message-content" id="message-content" />
          <span class="focus-input"></span>
        </div>
        <button class="button-guest-chat" type="submit">Send</button>
      </form>
      <div class="box-chat-button" data-url="{{ route('conversation.get-employee') }}">Start Chat</div>
    </div>
    <!-- Popup NewStudent -->
    <a href="#" class="new-student" data-url="{{ route('checkout.new') }}">
      <div class="student-img">
        <img src="{{ asset('images/Quy.jpg') }}" alt="" class="new-student-thumbnail">
      </div>
      <div class="student-content">
        <div class="student-name">
          <b class="new-student-name">Nguyen Thanh Tung</b> just signed up for the
          <b class="new-course-name">Master Excel, Word, Powerpoint</b>
        </div>
        <div><b class="new-teacher-name">Dinh Hong Linh</b></div>
        <div class="student-time">Just now</div>
      </div>
    </a>

    @include('layouts.footer')
    <!-- Loading -->
    <div class="loading">
      <a href="{{ route('index') }}" class="logo logo-animation">
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
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    var route_search = "{{ route('search.popup') }}";
    var ip_address = "{{ $_SERVER['REMOTE_ADDR'] }}";
    var get_message = "{{ route('conversation.massage.get') }}";
    var hasConversation = '{{ $hasConversation ?? 0 }}' == 1 ? true : false;
  </script>
  <script type="module" src="{{ asset('js/global.js') }}"></script>
  @yield('js')
</body>

</html>
