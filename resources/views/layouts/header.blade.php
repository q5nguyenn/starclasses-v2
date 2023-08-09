@php
  use App\Models\Department;
  use App\Models\Faculty;
  use App\Models\User;
  use App\Models\OnlineUser;
  $faculties = Faculty::all();
  $departments = Department::all();
  $user = Auth::user();
  $carts = $user->carts ?? [];
  if ($user) {
      $unreadNotices = $user->unreadNotices();
  }
  //Check has Conversation
@endphp
<!-- nav - bar - start -->
<div class="navs">
  <div class="nav-desktop">
    <a href="{{ route('index') }}" class="logo logo-animation">
      <div class="logo-inner">
        <img src="{{ asset('images/logo.png') }}" alt="" />
      </div>
      <span class="logo-title logo-title-nav">Star Classes</span>
    </a>
    <!-- <div class="nav-item">
      <i class="bi bi-grid-3x3-gap-fill"></i>
      </div> -->
    <div class="nav-item nav-menu">
      <span>Categories</span><i class="bi bi-chevron-up"></i>
      <div class="tabs">
        <div class="tab-items">
          @foreach ($faculties as $faculty)
            <div class="tab-item" data-faculty="{{ $faculty->id }}">
              <a href="{{ route('faculty', ['slug' => $faculty->slug]) }}" style="display:block">
                {!! $faculty->icon !!}
                <span>{{ $faculty->name }}</span>
              </a>
            </div>
          @endforeach
        </div>
        @foreach ($faculties as $faculty)
          <div class="tab-item-inner" data-faculty-parent="{{ $faculty->id }}">
            @foreach ($departments as $department)
              @if ($department->faculty_id == $faculty->id)
                <a href="{{ route('department', ['slug' => $department->slug]) }}" class="tab-item-link"
                  style="display:block">
                  {{ $department->name }}
                </a>
              @endif
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
    <form class="nav-item nav-search" id="nav-search" autocomplete="off" method="get" action="{{ route('search') }}">
      <label for="search-item"><i class="bi bi-search"></i></label>
      <input type="text" id="search-item" placeholder="Search for anything" name="keyword" />
      <span class="focus-input"></span>
    </form>
    <div class="nav-item nav-link nav-voucher">
      <a href="{{ route('profile', ['slug' => 'active-code']) }}" id="active-voucher-top">Activate Code</a>
    </div>
    <a class="nav-item nav-link nav-cart" href="{{ route('profile', ['slug' => 'order-history']) }}">
      <div id="cart-top"><i class="bi bi-bag-fill"></i></div>
      <span id="cart-course" style="display:{{ count($carts) == 0 ? 'none' : 'flex' }}">{{ count($carts) }}</span>
    </a>
    <!-- <div class="nav-item">
    <input type="checkbox" id="switch" class="switch-input" />
    <label for="switch" class="switch"></label>
    </div> -->
    <div class="count-online">
      <i class="bi bi-person"></i>
      <span class="count-online-value" data-url="{{ route('count.online.user') }}">999</span>
      <span class="count-online-text">&nbsp;online</span>
    </div>
    @if (Auth::check())
      @hasPermission('admin_home')
        <a href="{{ route('admin.index') }}" class="logo logo-animation" style="margin-left : 10px">
          <div class="logo-inner">
            <img src="{{ asset('images/user-protection.png') }}" alt="" />
          </div>
        </a>
      @endhasPermission
      <div class="nav-user">
        <a class="nav-user-img" href="{{ route('profile', ['slug' => 'infomation']) }}">
          <img src="{{ $user->thumbnail }}" alt="" />
          <span class="user-notification-point"
            style="display:{{ $unreadNotices == 0 ? 'none' : 'flex' }}">{{ $unreadNotices }}</span>
        </a>
        <div class="nav-user-dropdown">
          <a class="nav-user-dropdown-top" href="{{ route('profile', ['slug' => 'infomation']) }}">
            <div class="nav-user-top-img">
              <img src="{{ $user->thumbnail }}" alt="" />
            </div>
            <div class="nav-user-top-info">
              <div class="nav-user-top-name">{{ $user->name }}</div>
              <div class="nav-user-top-email">{{ $user->email }}</div>
            </div>
          </a>
          <div class="nav-user-dropdown-item">
            <a href="{{ route('profile', ['slug' => 'learning']) }}">My learning</a>
            <a href="{{ route('profile', ['slug' => 'order-history']) }}">My cart</a>
            <a href="{{ route('profile', ['slug' => 'active-code']) }}">Active Code</a>
            <a href="{{ route('profile', ['slug' => 'wishlist']) }}">Wishlist</a>
          </div>
          <div class="nav-user-dropdown-item">
            <a href="{{ route('profile', ['slug' => 'notification']) }}">Notifications</a>
            <span class="user-notification-point"
              style="display:{{ $unreadNotices == 0 ? 'none' : 'flex' }}">{{ $unreadNotices }}</span>
          </div>
          <div class="nav-user-dropdown-item">
            <a href="{{ route('profile', ['slug' => 'infomation']) }}">Edit profile</a>
          </div>
          <div class="nav-user-dropdown-item">
            <a href="{{ route('about.us') }}">Help</a>
            <a href="{{ route('logout') }}" id="signout">Log out</a>
          </div>
        </div>
      </div>
    @else
      <div class="nav-sign" style="display:flex">
        <div class="nav-item button">
          <a href="{{ route('signin', ['previous' => Request::url()]) }}">Log in</a>
        </div>
        <div class="nav-item button active">
          <a href="{{ route('signup') }}">Sign up</a>
        </div>
      </div>
    @endif
  </div>
  <div class="nav-mobile">
    <div class="nav-mobile-button"><i class="bi bi-list"></i></div>
    <a href="{{ route('index') }}" class="logo logo-animation">
      <div class="logo-inner">
        <img src="{{ asset('images/logo.png') }}" alt="" />
      </div>
    </a>
    <div class="nav-mobile-right">
      <div id="search-mobile">
        <i class="bi bi-search-heart-fill"></i>
      </div>
      <div class="nav-cart-mobile">
        <a href="{{ route('profile', ['slug' => 'order-history']) }}" id="cart-top-mobile"><i
            class="bi bi-bag-fill"></i>
        </a>
        <span id="cart-course-mobile"
          style="display:{{ count($carts) == 0 ? 'none' : 'flex' }}">{{ count($carts) }}</span>
      </div>
      <div class="nav-mobile-account">
        <i class="bi bi-person-fill"></i>
        <div class="nav-user-dropdown-mobile">
          @if (Auth::check())
            <div class="user-login">
              <a class="nav-user-dropdown-top" href="{{ route('profile', ['slug' => 'infomation']) }}">
                <div class="nav-user-top-info">
                  <div class="nav-user-top-name-mobile"></div>
                  <div class="nav-user-top-email-mobile"></div>
                </div>
              </a>
              <div class="nav-user-dropdown-item">
                <a href="{{ route('profile', ['slug' => 'learning']) }}">My learning</a>
                <a href="{{ route('profile', ['slug' => 'order-history']) }}">My cart</a>
                <a href="{{ route('profile', ['slug' => 'active-code']) }}">Active code</a>
                <a href="{{ route('profile', ['slug' => 'wishlist']) }}">Wishlist</a>
              </div>
              <div class="nav-user-dropdown-item">
                <a href="{{ route('profile', ['slug' => 'infomation']) }}">Notifications</a>
                <span class="user-notification-point"
                  style="display:{{ $unreadNotices == 0 ? 'none' : 'flex' }}">{{ $unreadNotices }}</span>
              </div>
              <div class="nav-user-dropdown-item">
                <a href="{{ route('profile', ['slug' => 'infomation']) }}">Edit profile</a>
              </div>
              <div class="nav-user-dropdown-item">
                <a href="{{ route('about.us') }}">Help</a>
                <a href="{{ route('logout') }}" id="signout-mobile">Log out</a>
              </div>
            </div>
          @else
            <div class="user-logout">
              <div class="nav-user-dropdown-item">
                <a href="{{ route('signin', ['previous' => Request::url()]) }}">Log in</a>
                <a href="{{ route('signup') }}">Sign up</a>
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
<!-- menu - mobile - start-->
<div class="nav-mobile-fixed-full">
  <div class="nav-mobile-fixed">
    <div class="nav-mobile-row-top">
      <a href="{{ route('index') }}" class="nav-mobile-item">
        <i class="bi bi-house-fill"></i> Home page</a>
      <i class="bi bi-x-lg"></i>
    </div>
    <div class="nav-moblie-row-mid"></div>
    <div class="nav-moblie-row">
      <a href="./about-us.html" class="nav-mobile-item"><i class="bi bi-headset"></i> Help</a>
    </div>
  </div>
</div>
<div class="nav-mobile-search-full">
  <form class="nav-item nav-search" id="nav-search-mobile" autocomplete="off" method="get"
    action="{{ route('search') }}">
    <label for="search-item-mobile"><i class="bi bi-search"></i></label>
    <input type="text" id="search-item-mobile" placeholder="Search for anything" name="keyword-mobile" />
    <i class="bi bi-x-lg close-search-mobile"></i>
  </form>
</div>
<!-- menu - mobile - end-->
<!-- nav - bar - end -->
