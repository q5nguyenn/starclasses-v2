<?php
use App\Models\User;
$user = Auth::user();
if ($user) {
    $unreadMessages = $user->unreadMessages();
}
?>
<div class="navs">
  <div class="nav-desktop">
    <a href="{{ route('index') }}" class="logo logo-animation">
      <div class="logo-inner">
        <img src="{{ asset('images/logo.png') }}" alt="" />
      </div>
      <span class="logo-title logo-title-nav">Star Classes</span>
    </a>
    <div style="width: 250px"></div>
    <form class="nav-item nav-search" id="nav-search" autocomplete="off">
      <label for="search-item"><i class="bi bi-search"></i></label>
      <input type="text" id="search-item" placeholder="Search for courses, accounts..." class="search-box"
        name="value" />
      <span class="focus-input"></span>
      {{-- <div class="search-result-popup" style="display: none;">
        <a class="search-result-item-popup" href="#">
        </a> --}}
  </div>

  </form>
  <div style="width: 250px"></div>
  <div class="nav-sign">
    @hasPermission('chat_home')
      <div class="nav-item">
        <a href="{{ route('chatapp.index') }}" class="position-relative">
          <i class="bi bi-chat-dots"></i>
          <span id="unread-message" class="position-absolute"
            @if ($unreadMessages == 0) style="display:none" @endif>&nbsp;</span>
        </a>
      </div>
    @endhasPermission
    <div class="nav-item">
      <a href="{{ route('admin.notification.index') }}" class="position-relative">
        <i class="bi bi-bell"></i>
        <span id="cart-course" class="position-absolute"
          @if (count($user->inboxs()) == 0) style="display:none" @endif>{{ count($user->inboxs()) }}</span>
      </a>
    </div>
  </div>
  <div class="nav-user">
    <div class="nav-user-img" href="./profile.html">
      <img src="{{ $user->thumbnail }}" alt="" />
    </div>
    <div class="nav-user-dropdown">
      <a class="nav-user-dropdown-top" href="{{ route('admin.user.edit', ['id' => Auth::id()]) }}">
        <div class="nav-user-top-img">
          <img src="{{ $user->thumbnail }}" alt="" />
        </div>
        <div class="nav-user-top-info">
          <div class="nav-user-top-name">{{ $user->name }}</div>
          <div class="nav-user-top-email">{{ $user->email }}</div>
        </div>
      </a>
      <div class="nav-user-dropdown-item">
        <a href="{{ route('admin.notification.sent') }}">Sent</a>
        <a href="{{ route('admin.notification.index') }}">Notifications</a>
      </div>
      <div class="nav-user-dropdown-item">
        <a href="{{ route('admin.user.edit', ['id' => Auth::id()]) }}">Edit profile</a>
      </div>
      <div class="nav-user-dropdown-item">
        <a href="{{ route('admin.help') }}">Help</a>
        <a href="{{ route('admin.signout') }}" id="signout">Log out</a>
      </div>
    </div>
  </div>
</div>
</div>
