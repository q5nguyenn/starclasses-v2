<?php
$preview = 'Preview';
if ($buyCourse) {
    $preview = 'Watch';
}
?>
@extends('master')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/coursedesc.css') }}">
@endsection
@section('title')
  <title>Star Classes - Course</title>
  <meta property="og:image" content="{{ $course->user->thumbnail }}" />
  <meta property="og:site_name" content="starclasses.edu.vn" />
  <meta property="og:description" content="{{ $course->description }}" />
  <meta property="og:title" content="{{ $course->name }}" />
  <meta property="og:url" content="{{ url()->full() }}" />
  <meta property="og:type" content="website" />
@endsection
@section('main')
  <!-- main - start -->
  <main class="course-desc-boss">
    <div class="course-top">
      <div class="course-wrapper">
        <div class="course-tree">
          <span>Star Classes</span><i class="bi bi-chevron-double-right"></i>
          <a id="section"
            href="{{ route('faculty', ['slug' => $course->department->faculty->slug]) }}">{{ $course->department->faculty->name }}</a>
          <i class="bi bi-chevron-double-right"></i>
          <a id="subject"
            href="{{ route('department', ['slug' => $course->department->slug]) }}">{{ $course->department->name }}</a>
        </div>
        <h2 class="course-name">{{ $course->name }}</h2>
        <div class="course-desc">{{ $course->name }}</div>
        <div class="course-info">
          <div class="coure-info-teacher">
            <div class="course-teacher-avatar">
              <img src="{{ $course->user->thumbnail }}" alt="" />
            </div>
            <a class="course-teacher-name" href="{{ route('teacher', ['slug' => $course->user->slug]) }}">
              {{ $course->user->name }}
            </a>
          </div>
          <div class="course-rate">
            <span class="course-star" id="course-star-display">
              {!! $course->getTemplStar($course->user->byRate()) !!}
            </span>
            <span id="rate">{{ $course->user->byRate() }} Rating</span>
          </div>
          <div class="course-students-count">
            <i class="bi bi-people-fill"></i>
            <span id="student">{{ $course->user->students() }} Students</span>
          </div>
          <div class="course-print">
            <i class="bi bi-printer-fill"></i>
            <span>Print course</span>
          </div>
          <div class="course-heart {{ $like ? 'like' : '' }}"
            data-delete="{{ route('wishlist.delete', ['id' => $course->id]) }}"
            data-create="{{ route('wishlist.store', ['id' => $course->id]) }}">
            <i class="bi bi-heart-fill"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="course-body">
      <div class="course-cover">
        <div class="video-container">
          <iframe width="956" height="538" src="https://www.youtube.com/embed/jfKfPfyJRdk"
            title="lofi hip hop radio - beats to relax/study to" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
        </div>
      </div>
      <div class="course-intro">
        <div class="course-intro-title">What you will learn</div>
        <div class="course-intro-wrapper">
          {!! $course->learn !!}
        </div>
      </div>
      <div class="course-content">
        <div class="course-content-title">Course content</div>
        <div class="course-content-info">
          <span class="course-number-section">{{ $parts }} parts</span>
          <i class="bi bi-dot"></i>
          <span class="course-time">Total time 4 hours 16 minutes</span>
        </div>
        <div class="course-content-list">
          @foreach ($chapters as $chapter)
            @if ($chapter->parent_id == 0)
              <div class="course-content-item">
                <div class="course-content-item-title chapter-parent">
                  <i class="bi bi-chevron-up rotate-reset"></i>
                  <span>{{ $chapter->content }}</span>
                </div>
                <div class="course-content-wrapper course-content-show chapter-child">
                  @foreach ($chapters as $index => $item)
                    @if ($chapter->id == $item->parent_id)
                      <div class="course-content-inner">
                        <i class="bi bi-file-earmark"></i>
                        <span class="count-content-name">{{ $item->content }}</span>
                        @if ($buyCourse)
                          <span class="count-content-video" data-url="{{ $item->video_link }}"
                            data-request="{{ route('progress.update', ['chapter_id' => $item->id]) }}">Watch</span>
                          <span class="{{ $item->completed() ? 'progress-complete' : 'progress-incomplete' }}"><i
                              class="bi bi-check-circle"></i></span>
                          <span class="count-content-time">0{{ rand(1, 9) }}:{{ rand(10, 59) }}</span>
                        @else
                          @if ($index <= 5)
                            <span class="count-content-video" data-url="{{ $item->video_link }}">Preview</span>
                            <span class="count-content-time">0{{ rand(1, 9) }}:{{ rand(10, 59) }}</span>
                          @else
                            <span class="count-content-video"></span>
                            <span class="count-content-time">0{{ rand(1, 9) }}:{{ rand(10, 59) }}</span>
                          @endif
                        @endif
                      </div>
                    @endif
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach
        </div>
      </div>
      <div class="course-content-info course-content-info-print">
        <div class="course-content-info-titlle">Course introduction</div>
        <div class="course-content-info-item" style="height: 200px; overflow: hidden;">
          {!! $course->introduction !!}
        </div>
        <div class="course-content-info-showmore" data-show="off">
          <i class="bi bi-chevron-down rotate-reset"></i>
          <span>Show more</span>
        </div>
      </div>
      <div class="course-relevant">
        <div class="course-content-info-titlle" style="margin-left: 10px">
          Related Courses
        </div>
        <div class="course-relevant-box"></div>
        @foreach ($relatedCourses as $relatedCourse)
          <a class="course-relevant-item" href="{{ route('course', ['slug' => $relatedCourse->slug]) }}">
            <div class="course-relevant-img">
              <img src="{{ $relatedCourse->thumbnail }}" alt="">
            </div>
            <div class="course-relevant-wrapper">
              <div class="course-relevant-info">
                <div class="course-relevant-name">{{ $relatedCourse->name }}</div>
                <div class="course-relevant-time">
                  <span>07 hours total</span><i class="bi bi-dot"></i>
                  <span>Update {{ date('d/m/Y', strtotime($relatedCourse->updated_at)) }}</span>
                </div>
              </div>
              <div class="course-relevant-star">
                <span>{{ $relatedCourse->byRate() }}</span>
                <span class="course-star">
                  <i class="bi bi-star-fill"></i>
                </span>
              </div>
              <div class="course-students-count">
                <i class="bi bi-people-fill"></i>
                <span>{{ count($relatedCourse->bills) }} Students</span>
              </div>
              <div class="course-relevant-price">
                <div>{{ $relatedCourse->discount }}$</div>
                <div>{{ $relatedCourse->price }}$</div>
              </div>
            </div>
          </a>
        @endforeach
        <div class="search-view-more">
          <a href="{{ route('department', ['slug' => $course->department->slug]) }}">
            <button class="button-fa" id="view-more">Show more</button>
          </a>
        </div>
      </div>

      <div class="course-teacher">
        <a class="course-teacher-title"
          href="{{ route('teacher', ['slug' => $course->user->slug]) }}">{{ $course->user->name }}</a>
        <div class="course-teacher-job">
          <div class="course-teacher-job">Teacher at: <b>{{ $course->user->department()->name }}</b></div>
        </div>
        <div class="course-teacher-info">
          <div class="course-teacher-img">
            <img src="{{ $course->user->thumbnail }}" alt="" />
          </div>
          <div class="course-teacher-info-class">
            <div class="course-teacher-info-item">
              <i class="bi bi-star-fill"></i>
              <span class="star-rate">{{ $course->user->byRate() }} Rating</span>
            </div>
            <div class="course-teacher-info-item">
              <i class="bi bi-award-fill"></i>
              <span class="view-rate">
                {{ $course->user->byReviews() }} Reviews
              </span>
            </div>
            <div class="course-teacher-info-item">
              <i class="bi bi-people-fill"></i>
              <span class="number-student">{{ $course->user->students() }} Students</span>
            </div>
            <div class="course-teacher-info-item">
              <i class="bi bi-play-circle-fill"></i>
              <span class="number-course">
                {{ count($course->user->courses) < 10 ? '0' . count($course->user->courses) : count($course->user->courses) }}
                Courses
              </span>
            </div>
          </div>
        </div>
        <div class="course-teach-text-desc">
          {{ $course->user->description }}
        </div>
      </div>
      <div class="course-comment">
        <div class="course-comment-title">
          <span class="course-star">
            <i class="bi bi-star-fill"></i>
          </span>
          <span>Course Reviews</span>
        </div>
        <div class="course-comment-wrapper">
          @foreach ($reviews as $review)
            <div class="course-comment-item">
              <div class="course-comment-item-top">
                <div class="course-comment-avatar">
                  <img src="{{ $review->user->thumbnail }}" alt="">
                </div>
                <div class="course-comment-rate">
                  <div class="course-comment-name">{{ $review->user->name }}</div>
                  <div class="course-commnet-rate-star">
                    <span class="course-star">
                      {!! $course->getTemplStar($review->rate) !!}
                    </span>
                    <span>{{ date('d/m/Y', strtotime($review->created_at)) }}</span>
                  </div>
                </div>
                <div class="course-comment-report">
                  <a class="course-comment-report-popup" data-url="{{ route('review.report', ['id' => $review]) }}">
                    Report
                  </a>
                  <i class="bi bi-three-dots-vertical"></i>
                </div>
              </div>
              <div class="course-comment-content">{{ $review->content }}</div>
              <div class="course-commnet-like">
                <span>Helpful?</span>
                <span>
                  <i class="bi bi-hand-thumbs-up"> </i>
                  <i class="bi bi-hand-thumbs-down"></i>
                </span>
              </div>
            </div>
          @endforeach
        </div>
        @if ($reviewsCount > 2)
          <button class="button-fa" id="get-more-comment" data-url="{{ route('review.index') }}">
            Show more
          </button>
        @endif
      </div>
      @if (Auth::check() && $buyCourse)
        <div class="course-comment course-comment-user">
          <form class="send-rate"
            action="{{ route('review.store', ['user_id' => Auth::user()->id, 'course_id' => $course->id]) }}"
            method="post">
            @csrf
            <div class="send-rate-top">
              <span>Enter your review</span><span class="course-star" id="course-star-rate">
                <i class="bi bi-star-fill" data-rate="1"></i>
                <i class="bi bi-star-fill" data-rate="2"></i>
                <i class="bi bi-star-fill" data-rate="3"></i>
                <i class="bi bi-star-fill" data-rate="4"></i>
                <i class="bi bi-star-fill" data-rate="5"></i>
              </span>
            </div>
            <textarea name="content" id="user-commnet" rows="3">{{ old('content') }}</textarea>
            <input type="text" name="rate" style="display:none" value="5">
            <span class="user-comment-error">&nbsp;
              @error('content')
                {{ $message }}
              @enderror
            </span>
            <button class="button-fa" id="send-user-comment" type="submit">
              Submit your review
            </button>
          </form>
        </div>
      @endif
    </div>
  </main>
  <!-- main - end -->
  <!-- Course Popup -->
  <div class="course-popup-container">
    <div class="course-popup-top">
      <div class="course-popup-price">
        <div>
          <span class="course-popup-nowprice">$ {{ $course->discount }}</span>
          <span class="course-popup-oldprice">$ {{ $course->price }}</span>
        </div>
        <span class="course-popup-percent-price">({{ $course->discountPercent() }}% OFF)</span>
      </div>
      <div class="course-popup-main-button">
        <button class="button-fa button-gradient" id="add-course"
          cart-create="{{ route('cart.store', ['id' => $course->id]) }}">
          @if ($buyCourse)
            You have already purchased this course
          @else
            @if ($cartCourse)
              This course is already in your cart
            @else
              Add to cart
            @endif
          @endif
        </button>
        <a href="{{ route('checkout-now.index', ['slug' => $course->slug]) }}" @disabled($buyCourse)>
          <button class="button-fa" id="buy-now" @disabled($buyCourse)>Buy now</button></a>
      </div>
      <div class="course-popup-remoney">30-Day Money-Back Guarantee</div>
      <div class="course-popup-include">
        <div class="course-popup-include-title">This course includes:</div>
        <div class="course-popup-item">
          <i class="bi bi-play-btn"></i>
          <span class="course-time">13 hours on-demand video</span>
        </div>
        <div class="course-popup-item">
          <i class="bi bi-file-earmark"></i>
          <span class="course-number-section">20 sections</span>
        </div>
        <div class="course-popup-item">
          <i class="bi bi-file-arrow-down"></i>
          <span>21 downloadable resources</span>
        </div>
        <div class="course-popup-item">
          <i class="bi bi-infinity"></i>
          <span>Full lifetime access</span>
        </div>
        <div class="course-popup-item">
          <i class="bi bi-phone"></i>
          <span>Access on mobile and TV</span>
        </div>
        <div class="course-popup-item">
          <i class="bi bi-trophy"></i>
          <span>Certificate of completion</span>
        </div>
      </div>
      <div class="course-popup-link">
        <div class="course-popup-link-item" id="fb-share-button">
          <i class="bi bi-share"></i>
          <div>Share</div>
        </div>
        <div class="course-popup-link-item course-gift">
          <i class="bi bi-person-hearts"></i>
          <div>Gift this course</div>
        </div>
        <a class="course-popup-link-item" id="voucher" href="{{ route('profile', ['slug' => 'active-code']) }}">
          <i class="bi bi-ticket-perforated"></i>
          <div>Apply Coupon</div>
        </a>
      </div>
    </div>
    <div class="course-popup-more">
      <div class="course-popup-more-title">Training 5 or more people?</div>
      <div>
        Get your team access to 17,000+ top Udemy courses anytime, anywhere.
      </div>
      <a class="button-fa button-alone" href="{{ route('become.teacher') }}">Try StarClasses Business</a>
    </div>
  </div>
  <!-- Course Popup Success -->
  <div class="popup-add-cart-sucess">
    <i class="bi bi-check-lg"></i>
    <span>Add to cart successfully</span>
    <a href="{{ route('profile', ['slug' => 'order-history']) }}">
      <button class=" button-fa button-gradient">
        View cart and checkout
      </button>
    </a>
  </div>
  <!-- Video Popup -->
  <div class="video">
    <div class="video-container">
      <iframe width="956" height="538" src="https://www.youtube.com/embed/jfKfPfyJRdk"
        title="lofi hip hop radio - beats to relax/study to" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        id="chapter_video_link" allowfullscreen></iframe>
    </div>
  </div>
  <div class="video-blur"></div>
  <!-- Share -->
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0"
    nonce="hBYXgR5J"></script>
@endsection
@section('js')
  <script>
    var login = {{ $login ? 'true' : 'false' }};
    var cartCourse = {{ $cartCourse ? 'true' : 'false' }};
    var buyCourse = {{ $buyCourse ? 'true' : 'false' }};
    var BASE_URL = '{{ env('BASE_URL') }}';
    var urlReport = '{{ route('review.report') }}';
    var course_id = {{ $course->id }};
  </script>
  <script type="module" src="{{ asset('js/coursedesc.js') }}"></script>
@endsection
