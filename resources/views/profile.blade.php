@extends('master')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
    type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/customSelect2.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/customFroala.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/customSweetalert2.css') }}">
  <style>
    ul li::after {
      background-color: #ffffff00;
    }

    .button {
      display: inline-block;
      border: none;
      font-size: 16px;
      cursor: pointer;
      color: white;
      background-image: var(--gradient-color);
      opacity: 0.8;
    }

    .button:hover {
      transition: 0.3s;
      opacity: 1;
    }
  </style>
@endsection
@section('title')
  <title>Star Classes - Profile</title>
@endsection
@section('main')
  @php
    if ($user) {
        $unreadNotices = $user->unreadNotices();
    }
  @endphp
  <!-- main - start -->
  <main class="profile">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="profile-cover">
      <div class="profile-cover-wrapper">
        <div class="profile-cover-title">Student:</div>
        <div class="profile-cover-menu">
          <a class="profile-cover-menu-item is-active" frame="0"
            href="{{ route('profile', ['slug' => 'infomation']) }}">
            <i class="bi bi-person-fill"></i>
            <span class="profile-cover-menu-item-content">Profile</span>
          </a>
          <a class="profile-cover-menu-item" frame="1" href="{{ route('profile', ['slug' => 'learning']) }}">
            <i class="bi bi-book-fill"></i>
            <span class="profile-cover-menu-item-content">My learning</span>
          </a>
          <a class="profile-cover-menu-item" frame="2" href="{{ route('profile', ['slug' => 'active-code']) }}">
            <i class="bi bi-ticket-fill"></i>
            <span class="profile-cover-menu-item-content">Activate Code</span>
          </a>
          <a class="profile-cover-menu-item" frame="3" href="{{ route('profile', ['slug' => 'support-request']) }}">
            <i class="bi bi-headset"></i>
            <span class="profile-cover-menu-item-content">Support request</span>
          </a>
          <a class="profile-cover-menu-item" frame="4" href="{{ route('profile', ['slug' => 'order-history']) }}">
            <i class="bi bi-bag-check-fill"></i>
            <span class="profile-cover-menu-item-content">Order history</span>
          </a>
          <a class="profile-cover-menu-item" frame="5" href="{{ route('profile', ['slug' => 'wishlist']) }}">
            <i class="bi bi-heart-fill"></i>
            <span class="profile-cover-menu-item-content">Wishlist</span>
          </a>
          <a class="profile-cover-menu-item" frame="6" href="{{ route('profile', ['slug' => 'notification']) }}"
            style="position: relative;">
            <i class="bi bi-bell-fill"></i>
            <span class="profile-cover-menu-item-content">Notification</span>
            <span class="user-notification-point"
              style="display:{{ $unreadNotices == 0 ? 'none' : 'flex' }}">{{ $unreadNotices }}</span>
          </a>
          <a class="profile-cover-menu-item" frame="7" href="{{ route('profile', ['slug' => 'send']) }}">
            <i class="bi bi-send-fill"></i>
            <span class="profile-cover-menu-item-content">Send</span>
          </a>
          <a class="profile-cover-menu-item change-pass" frame="8"
            href="{{ route('profile', ['slug' => 'change-password']) }}">
            <i class="bi bi-key-fill"></i>
            <span class="profile-cover-menu-item-content">Change password
            </span>
          </a>
        </div>
      </div>
    </div>
    <form class="profile-frame show" data-frame="0" method="post"
      action="{{ route('profile.update', ['id' => $user->id]) }}" enctype="multipart/form-data" id="update-profile">
      @csrf
      <div class="profile-frame-top profile-frame-flex">
        <div class="profile-frame-title">Public profile</div>
        <a class="profile-frame-changepass button-fa button-small button"
          href="{{ route('profile', ['slug' => 'change-password']) }}">
          <i class="bi bi-arrow-repeat"></i>Change password
        </a>
      </div>
      <div class="profile-frame-wrapper profile-frame-flex profile-frame-flex-mobile profile-frame-flex-gap">
        <div class="profile-frame-column">
          <div>Choose your avatar</div>
          <label for="thumbnail" class="profile-frame-avatar">
            <img src="{{ $user->thumbnail }}" alt="" />
            <span><i class="bi bi-camera-fill"></i></span>
          </label>
          <input type="file" id="thumbnail" accept="image/*" name="thumbnail" hidden />
          <div class="input-item-error">&nbsp;
            @error('thumbnail')
              {{ $message }}
            @enderror
          </div>
          <label for="description">Short description</label>
          <div class="input-item">
            <textarea name="description" id="description" class="input">{{ old('description', $user->description) }}</textarea>
            <span class="focus-input"></span>
          </div>
        </div>
        <div class="profile-frame-column">
          <div class="profile-frame-username">
            <span>Username:</span> <b>{{ $user->email }}</b>
          </div>
          <label for="name">Full name</label>
          <div class="input-item">
            <input type="text" class="input" id="name" name="name"
              value="{{ old('name', $user->name) }}" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('name')
              {{ $message }}
            @enderror
          </div>
          <label for="email">Email</label>
          <div class="input-item">
            <input type="text" class="input" id="email" name="email"
              value="{{ old('email', $user->email) }}" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('email')
              {{ $message }}
            @enderror
          </div>
          <label for="birth_day">Date of birth</label>
          <div class="input-item ">
            <input type="date" class="input" id="birth_day" name="birth_day"
              value="{{ old('birth_day', $user->birth_day) }}" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('birth_day')
              {{ $message }}
            @enderror
          </div>
          <label for="phone_number">Phone number</label>
          <div class="input-item">
            <input type="number" class="input" id="phone_number" name="phone_number"
              value="{{ old('phone_number', $user->phone_number) }}" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('phone_number')
              {{ $message }}
            @enderror
          </div>
          <div class="input-item">
            <label for="province_id">Address</label>
            <select class="form-control js-province-tokenizer" name="province_id" style="width: 100%"
              id="province_id">
              <option value=""></option>
              @foreach ($provinces as $province)
                <option value="{{ $province->id }}"
                  {{ old('province_id', $user->province_id) == $province->id ? 'selected' : '' }}>
                  {{ $province->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="input-item-error">&nbsp;
            @error('province_id')
              {{ $message }}
            @enderror
          </div>
          <button class="button-fa flex-right btn-update-user" type="submit" id="btn-update">Save</button>
          <div class="popup-request" id="popup-update">
            <div class="popup-request-wrapper">
              <div class="popup-request-img">
                <img src="{{ asset('images/check.png') }}" alt="">
              </div>
              <div class="popup-request-content">
                <b>Update successful!</b>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="profile-frame" data-frame="1">
      <div class="profile-frame-top profile-frame-flex">
        <div class="profile-frame-title">My learning</div>
      </div>
      <div class="profile-frame-wrapper profile-frame-flex profile-frame-mobile">
        <div class="profile-frame-column">
          <div class="profile-frame-title">Studying</div>
          <div id="studying">
            @foreach ($buyCourses as $course)
              @php
                $progress = round(($course->completedChapter($user->id) * 100) / $course->allChapters());
              @endphp
              @if ($progress < 100)
                <a class="course-profile-item" href="{{ route('course', ['slug' => $course->slug]) }}">
                  <div class="course-profile-img">
                    <img src="{{ $course->thumbnail }}" alt="">
                  </div>
                  <div class="course-profile-wrapper">
                    <div class="course-profile-info">
                      <div class="course-profile-name">{{ $course->name }}</div>
                      <div class="course-profile-teacher">
                        <div class="course-profile-teacher-img">
                          <img src="{{ $course->user->thumbnail }}" alt="">
                        </div>
                        <div class="course-profile-teacher-name">
                          {{ $course->user->name }}
                        </div>
                      </div>
                    </div>
                    <div class="course-profile-finish">
                      <span>{{ $course->completedChapter($user->id) }}</span>
                      <span>/{{ $course->allChapters() }}</span>
                    </div>
                    <div class="course-profile-progress" data-progress="">
                      <span
                        style="width:{{ round(($course->completedChapter($user->id) * 100) / $course->allChapters()) }}%"></span>
                    </div>
                  </div>
                </a>
              @endif
            @endforeach
          </div>
        </div>
        <div class="profile-frame-column">
          <div class="profile-frame-title">Finished</div>
          <div id="end-study">
            @foreach ($buyCourses as $course)
              @php
                $progress = round(($course->completedChapter($user->id) * 100) / $course->allChapters());
              @endphp
              @if ($progress == 100)
                <a class="course-profile-item" href="{{ route('course', ['slug' => $course->slug]) }}">
                  <div class="course-profile-img">
                    <img src="{{ $course->thumbnail }}" alt="">
                  </div>
                  <div class="course-profile-wrapper">
                    <div class="course-profile-info">
                      <div class="course-profile-name">{{ $course->name }}</div>
                      <div class="course-profile-teacher">
                        <div class="course-profile-teacher-img">
                          <img src="{{ $course->user->thumbnail }}" alt="">
                        </div>
                        <div class="course-profile-teacher-name">
                          {{ $course->user->name }}
                        </div>
                      </div>
                    </div>
                    <div class="course-profile-finish">
                      <span>{{ $course->completedChapter($user->id) }}</span>
                      <span>/{{ $course->allChapters() }}</span>
                    </div>
                    <div class="course-profile-progress" data-progress="">
                      <span
                        style="width:{{ round(($course->completedChapter($user->id) * 100) / $course->allChapters()) }}%"></span>
                    </div>
                  </div>
                </a>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top" style="margin-bottom: 20px">
        <div class="profile-frame-title">Activate Code</div>
      </div>
      <div class="profile-frame-wrapper">
        <div class="profile-frame-wrapper-title">
          Use for COD or E-voucher encryption
          <p>
            Note: Each activation code can only be used once. Enter your
            activation code
          </p>
        </div>
        <div class="profile-frame-vocher-img">
          <img src="{{ asset('images/voucher.png') }}" alt="" />
        </div>
        <form class="profile-frame-flex profile-frame-width" id="active-voucher" novalidate method="post"
          action="{{ route('code.active') }}">
          @csrf
          <div class="input-item">
            <input type="text" class="input" id="code" placeholder="Enter voucher code" name="name" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;</div>
          <button class="button-fa button-active-voucher-mobile" type="submit" id="active-code"
            data-url="{{ route('code.active') }}">
            Activate Code
          </button>
        </form>
        <div class="profile-frame-wrapper-title voucher-content"></div>
      </div>
    </div>
    <div class="profile-frame" data-frame="3">
      <div class="profile-frame-top profile-frame-flex">
        <div class="profile-frame-title">Support request</div>
      </div>
      <div class="profile-frame-wrapper profile-frame-flex">
        <div class="profile-frame-column profile-frame-column-support">
          <div class="profile-frame-box">
            <div class="profile-frame-title">Support time</div>
            <p>
              Star Classes support time is from 9:00 to 18:00 from Monday to
              Friday. However, we will prioritize support for important
              issues outside of business hours.
            </p>
          </div>
          <div class="input-item-error">&nbsp;
          </div>
          <form action="{{ route('report') }}" method="post" enctype="multipart/form-data" id="report">
            @csrf
            <select class="form-control js-error-tokenizer" name="type" style="width: 100%" id="error">
              <option value=""></option>
              <option value="Order problem" {{ old('type') == 'Order problem' ? 'selected' : '' }}>
                Order problem
              </option>
              <option value="Voucher activation code" {{ old('type') == 'Voucher activation code' ? 'selected' : '' }}>
                Voucher
                activation code</option>
              <option value="Account" {{ old('type') == 'Account' ? 'selected' : '' }}>Account</option>
              <option value="Report system error" {{ old('type') == 'Report system error' ? 'selected' : '' }}>Report
                system
                error</option>
              <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <div class="input-item-error">&nbsp;
              @error('type')
                {{ $message }}
              @enderror
            </div>
            {{-- <span class="dropdown-menu-alert"
                >*You must choose the type of support.</span
              ><br /> --}}
            <label for="error-desc">Short description</label>
            <div class="input-item">
              <textarea name="description" id="error-desc" class="input input-free">{{ old('description') }}</textarea>
              <span class="focus-input"></span>
            </div>
            <div class="input-item-error">&nbsp;
              @error('description')
                {{ $message }}
              @enderror
            </div>
            <div class="profile-frame-flex">
              <div class="image-error-item">
                <label for="image-report01">
                  <img src="{{ asset('images/image.png') }}" alt="" id="img-report01" />
                </label>
                <input type="file" id="image-report01" class="image-request" accept="image/*"
                  name="image-report01" />
                <div class="input-item-error">&nbsp;
                  @error('image-report01')
                    {{ $message }}
                  @enderror
                </div>
              </div>
              <div class="image-error-item">
                <label for="image-report02">
                  <img src="{{ asset('images/image.png') }}" alt="" id="img-report02" />
                </label>
                <input type="file" id="image-report02" class="image-request" accept="image/*"
                  name="image-report02" />
                <div class="input-item-error">&nbsp;
                  @error('image-report02')
                    {{ $message }}
                  @enderror
                </div>
              </div>
              <div class="image-error-item">
                <label for="image-report03">
                  <img src="{{ asset('images/image.png') }}" alt="" id="img-report03" />
                </label>
                <input type="file" id="image-report03" class="image-request" accept="image/*"
                  name="image-report03" />
                <div class="input-item-error">&nbsp;
                  @error('image-report03')
                    {{ $message }}
                  @enderror
                </div>
              </div>
            </div>
            <button class="button-fa" id="btn-request" style="width: 100%" type="submit">
              Submit a support request
            </button>
          </form>
          <div class="popup-request" id="popup-report">
            <div class="popup-request-wrapper">
              <div class="popup-request-img">
                <img src="{{ asset('images/error.png') }}" alt="" />
              </div>
              <div class="popup-request-content">
                Your support request has been sent to us. We will fix it as
                soon as possible. <br />
                An email will be sent to you when the request is
                processed.<br />
                <b>Thank you very much!</b>
              </div>
            </div>
          </div>
        </div>
        <div class="profile-frame-column mobile-picture">
          <div class="profile-frame-support-img">
            <img src="{{ asset('images/support.png') }}" alt="" />
          </div>
        </div>
      </div>
    </div>
    <div class="profile-frame position-relative" data-frame="4">
      <div class="profile-frame-top profile-frame-flex">
        <div class="profile-frame-title">Order history</div>
      </div>
      <div class="profile-frame-wrapper profile-frame-flex profile-frame-mobile">
        <div class="profile-frame-column">
          <div class="profile-frame-title">In the cart</div>
          <div id="course-in-cart">
            @foreach ($carts as $cart)
              <a class="course-profile-item" href="{{ route('course', ['slug' => $cart->course->slug]) }}">
                <div class="course-profile-img">
                  <img src="{{ $cart->course->thumbnail }}" alt="">
                </div>
                <div class="course-profile-wrapper">
                  <div class="course-profile-info">
                    <div class="course-profile-name">{{ $cart->course->name }}</div>
                    <div class="course-profile-teacher">
                      <div class="course-profile-teacher-img">
                        <img src="{{ $cart->course->user->thumbnail }}" alt="">
                      </div>
                      <div class="course-profile-teacher-name">{{ $cart->course->user->name }}</div>
                    </div>
                  </div>
                  <div class="course-profile-price">
                    <div>{{ $cart->course->discount }}$</div>
                    <div>{{ $cart->course->price }}$</div>
                  </div>
                  <div class="course-profile-delele" data-url="{{ route('cart.delete', ['id' => $cart->id]) }}">
                    <i class="bi bi-x-lg"></i>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
          @if (count($carts) > 0)
            <a class="button-a button-fa button-right-bottom" id="payment" href="{{ route('checkout.index') }}">
              Checkout
            </a>
          @endif
        </div>
        <div class="profile-frame-column">
          <div class="profile-frame-title">Purchased courses</div>
          <div id="course-bought">
            @foreach ($buyCourses as $buyCourse)
              <a class="course-profile-item" href="{{ route('course', ['slug' => $buyCourse->slug]) }}">
                <div class="course-profile-img">
                  <img src="{{ $buyCourse->thumbnail }}" alt="">
                </div>
                <div class="course-profile-wrapper">
                  <div class="course-profile-info">
                    <div class="course-profile-name">{{ $buyCourse->name }}</div>
                    <div class="course-profile-teacher">
                      <div class="course-profile-teacher-img">
                        <img src="{{ $buyCourse->user->thumbnail }}" alt="">
                      </div>
                      <div class="course-profile-teacher-name">{{ $buyCourse->user->name }}</div>
                    </div>
                  </div>
                  <div class="course-profile-price">
                    <div>{{ $buyCourse->discount }}$</div>
                    <div>{{ $buyCourse->price }}$</div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="profile-frame" data-frame="5">
      <div class="profile-frame-top profile-frame-flex">
        <div class="profile-frame-title">Wistlist</div>
      </div>
      <div class="profile-frame-wrapper profile-frame-flex">
        <div class="profile-frame-column">
          <div class="profile-frame-title"></div>
          <div id="like-course">
            @foreach ($wishlists as $wishlist)
              <a class="course-profile-item" href="{{ route('course', ['slug' => $wishlist->course->slug]) }}">
                <div class="course-profile-img">
                  <img src="{{ $wishlist->course->thumbnail }}" alt="">
                </div>
                <div class="course-profile-wrapper">
                  <div class="course-profile-info">
                    <div class="course-profile-name">{{ $wishlist->course->name }}</div>
                    <div class="course-profile-teacher">
                      <div class="course-profile-teacher-img">
                        <img src="{{ $wishlist->course->user->thumbnail }}" alt="">
                      </div>
                      <div class="course-profile-teacher-name">{{ $wishlist->course->user->name }}</div>
                    </div>
                  </div>
                  <div class="course-profile-price">
                    <div>{{ $wishlist->course->discount }}$</div>
                    <div>{{ $wishlist->course->discount }}$</div>
                  </div>
                  <div class="course-profile-delele"
                    data-url="{{ route('wishlist.delete', ['id' => $wishlist->id]) }}">
                    <i class="bi bi-x-lg"></i>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
        <div class="profile-frame-column mobile-picture">
          <div class="profile-frame-title"></div>
          <div class="profile-frame-like-course-img">
            <img src="{{ asset('images/love.png') }}" alt="" />
          </div>
        </div>
      </div>
    </div>
    <div class="profile-frame" data-frame="6">
      <div class="profile-frame-top" style="margin-bottom: 20px">
        <div class="profile-frame-title">Notification</div>
      </div>
      <div class="profile-notification">
        @foreach ($notifications as $noti)
          <div class="profile-notification-item" data-url="{{ route('notification.update', ['id' => $noti->id]) }}">
            <div class="profile-notification-item-from" style="width:290px; flex-grow: 0">
              <div class="profile-notification-item-avatar" style="display: none">
                <img src="{{ $noti->user->thumbnail }}" alt="">
              </div>
              <div class="profile-notification-item-name {{ $noti->read() ? '' : 'notification-unread' }}">
                {{ $noti->user->name }}
                <span class="profile-notification-item-email" style="display:none">&#60;{{ $noti->user->email }}
                  &#62;</span>
                <span class="profile-notification-item-to" style="display:none">
                  to
                  @foreach ($noti->users as $index => $user)
                    @if ($index != count($noti->users) - 1)
                      <span>{{ $user->email }},</span>
                    @else
                      <span>{{ $user->email }}</span>
                    @endif
                  @endforeach
                </span>
              </div>
            </div>
            <div class="profile-notification-item-body">
              <div class="profile-notification-item-body-top">
                <div class="profile-notification-item-title {{ $noti->read() ? '' : 'notification-unread' }}">
                  {{ $noti->title }}
                </div>
                <div class="profile-notification-item-date">
                  {{ date('d/m/Y', strtotime($noti->created_at)) }}
                </div>
                <a href="{{ route('notification.delete', ['id' => $noti->notifications_userID]) }}"
                  class="action-delete"
                  data-url="{{ route('notification.delete', ['id' => $noti->notifications_userID]) }}"
                  style="display:none">
                  <i class="bi bi-trash3"></i>
                </a>
              </div>
              <div class="profile-notification-item-content" style="display: none">{!! $noti->content !!}
                <a class="button-fa button-small button btn-reply"
                  href="{{ route('notification.create', ['notification' => $noti->id, 'to' => $noti->user->id]) }}"
                  style="margin-top:20px; width:90px; text-align:center">
                  <i class="bi bi-reply"></i>Reply
                </a>
                <a class="button-fa button-small btn-reply"
                  href="{{ route('notification.create', ['notification' => $noti->id, 'to' => $noti->user->id, 'forward' => true]) }}"
                  style="margin-top:20px; width:90px">
                  <i class="bi bi-arrow-return-right"></i>Forward
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="custom-pagination"">
        {{ $notifications->links() }}
      </div>
    </div>
    <div class="profile-frame" data-frame="7">
      <div class="profile-frame-top" style="margin-bottom: 20px; display: flex">
        <div class="profile-frame-title" style="flex-grow: 1">Notifications sent</div>
        <a class="profile-frame-changepass button-fa button-small button btn-reply"
          href="{{ route('notification.create') }}">
          <i class="bi bi-pencil-square"></i></i>Compose
        </a>
      </div>
      <div class="profile-notification">
        @foreach ($send_notifications as $noti)
          <div class="profile-notification-item">
            <div class="profile-notification-item-from" style="width:290px; flex-grow: 0">
              <div class="profile-notification-item-name">
                <span class="profile-notification-item-send-to">
                  To:
                  @foreach ($noti->users as $index => $user)
                    @if ($index != count($noti->users) - 1)
                      <span>{{ $user->email }},</span>
                    @else
                      <span>{{ $user->email }}</span>
                    @endif
                  @endforeach
                </span>
              </div>
            </div>
            <div class="profile-notification-item-body">
              <div class="profile-notification-item-body-top">
                <div class="profile-notification-item-title">
                  {{ $noti->title }}
                </div>
                <div class="profile-notification-item-date">
                  {{ date('d/m/Y', strtotime($noti->created_at)) }}
                </div>
                <a href="{{ route('notification.sent.delete', ['id' => $noti->id]) }}" class="action-delete"
                  data-url="{{ route('notification.sent.delete', ['id' => $noti->id]) }}" style="display:none">
                  <i class="bi bi-trash3"></i>
                </a>
              </div>
              <div class="profile-notification-item-content" style="display: none">{!! $noti->content !!}
                <a class="button-fa button-small button btn-edit"
                  href="{{ route('notification.edit', ['notification' => $noti->id]) }}"
                  style="margin-top:20px; width:90px; text-align:center">
                  <i class="bi bi-pen"></i>Edit
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="profile-frame" data-frame="8">
      <div class="profile-frame-top" style="margin-bottom: 20px">
        <div class="profile-frame-title alert-update-password" style="margin-bottom: 50px">
          <i class="bi bi-key"></i> Password update
        </div>
      </div>
      <form class="profile-frame-wrapper" method="post" action="{{ route('profile.changepassword') }}">
        @csrf
        <div class="profile-frame-center">
          <div class="input-item-wrapper">
            <label for="password">Old password</label>
            <div class="input-item-right">
              <div class="input-item">
                <input type="password" class="input" id="password" name="password" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('password')
                  {{ $message }}
                @enderror
              </div>
            </div>
          </div>
          <div class="input-item-wrapper">
            <label for="password_new">New password</label>
            <div class="input-item-right">
              <div class="input-item">
                <input type="password" class="input" id="password_new" name="password_new" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('password_new')
                  {{ $message }}
                @enderror
              </div>
            </div>
          </div>
          <div class="input-item-wrapper">
            <label for="password_new_confirmation">Re-type new password</label>
            <div class="input-item-right">
              <div class="input-item">
                <input type="password" class="input" id="password_new_confirmation"
                  name="password_new_confirmation" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('password_new_confirmation')
                  {{ $message }}
                @enderror
              </div>
            </div>
          </div>
          <div class="input-item-wrapper">
            <div class="term">
              <input type="checkbox" id="checkbox1" />
              <label class="checkbox" for="checkbox1"></label>
              <label for="checkbox1">
                <span> Show password </span>
              </label>
            </div>
          </div>
          <div style="text-align: center; margin-top: 20px">
            <button class="button-fa" id="change-pass">
              Change password
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="popup-reply-notification" style="display:none">
      <form method="post" action="" style="height:100%" id="notification-store">
        @csrf
        <input type="text" name="notification-id" id="notification-id" hidden>
        <div class="reply-notification-top">
          <input class="reply-notification-re" name="title" id="title" placeholder="Title"></input>
          <div class="reply-notification-icon">
            <i class="bi bi-x-square"></i>
          </div>
        </div>
        <div class="input-item-error">
        </div>
        <div class="reply-notification-to" style="display:flex">
          <i class="bi bi-arrow-return-right"></i>
          <select class="form-control js-user-tokenizer" multiple="multiple" name="users[]" id="users"
            style="width:100%">
          </select>
        </div>
        <div class="input-item-error">
        </div>
        <div class="reply-notification-body">
          <textarea id="content" name="content"></textarea>
        </div>
        <div class="input-item-error">
        </div>
        <div class="reply-notification-footer">
          <button class="button button-fa buttton-small" style="padding: 5px; width:90px" id="btn-send"
            data-url="{{ route('notification.store') }}">
            <i class="bi bi-send"></i>Send
          </button>
        </div>
    </div>
    </form>
    </div>
  </main>
  <!-- main - end -->
@endsection
@section('js')
  <script>
    let frame = {{ $frame }};
    let notification_store = '{{ route('notification.store') }}';
    let notification_save = '{{ route('notification.save') }}';
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
  </script>
  <script type="module" src="{{ asset('js/profile.js') }}"></script>
  @if (session('Alert'))
    <script>
      $('#popup-update').css('display', 'flex');
      setTimeout(() => {
        $('#popup-update').css('display', 'none');
      }, 1000);
    </script>
  @endif
  @if (session('popup_report'))
    <script>
      $('#popup-report').css('display', 'flex');
      setTimeout(() => {
        $('#popup-report').css('display', 'none');
      }, 2000);
    </script>
  @endif
  @php
    session()->forget('Alert');
    session()->forget('popup_report');
  @endphp
@endsection
