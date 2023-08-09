@extends('master')
@section('title')
  <title>Star Classes</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/course.css') }}">
@endsection
@section('main')
  <!-- main - start -->
  <main>
    <div class="menus">
      <div class="slides">
        <div class="slide-imgs">
          @foreach ($sliders as $slider)
            <a class="slide-img" href="./course/{{ $slider->course->slug }}">
              <img src="{{ $slider->thumbnail }}" alt="" />
            </a>
          @endforeach
        </div>
        <div class="slide-dots">
          @foreach ($sliders as $index => $slider)
            @if ($index == 0)
              <span class="dot-active"></span>
            @else
              <span></span>
            @endif
          @endforeach
        </div>
      </div>
    </div>
    <div class="hot-topic">
      <div class="hot-topic-top">
        <h2>BEST SELLERS</h2>
        <a class="hot-topic-viewmore"
          href="{{ route('search', ['sort_by' => 'price-desc', 'keyword' => '', 'desc' => 'BEST SELLERS']) }}">
          <span>View more</span><i class="bi bi-chevron-double-right"></i>
        </a>
      </div>
      <div class="hot-topic-body" id="top-buy">
        @foreach ($bestSeller as $course)
          <a href="{{ route('course', ['slug' => $course->slug]) }}" class="course-item">
            <div class="slale-percent">-{{ $course->discount_percent }}%</div>
            <div class="course-img">
              <img src="{{ $course->thumbnail }}" alt="">
            </div>
            <div class="course-wrapper">
              <h3 class="course-title">
                {{ $course->name }}
              </h3>
              <div class="course-author">{{ $course->user->name }}</div>
              <div class="course-review">
                <span class="course-point">{{ $course->byRate() }}</span>
                <span class="course-star">
                  {!! $course->getTemplStar($course->byRate()) !!}
                </span>
                <span class="course-review-count">({{ count($course->reviews) }})</span>
              </div>
              <div class="course-price">
                <span class="course-price-sale">{{ $course->discount }}$</span>
                <span class="course-price-old">{{ $course->price }}$</span>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>

    <div class="hot-topic">
      <div class="hot-topic-top">
        <h2>SPECIAL OFFERS TODAY</h2>
        <a class="hot-topic-viewmore" href="./search.html?filter=top-sale">
          <span>View more</span><i class="bi bi-chevron-double-right"></i>
        </a>
      </div>
      <div class="hot-topic-body" id="top-discount"></div>
    </div>

    <div class="trending">
      <div class="trending-wrapper">
        <div class="trending-item new-course">
          <div class="hot-topic-top">
            <h2>NEW RELEASES</h2>
            <a class="hot-topic-viewmore"
              href="{{ route('search', ['sort_by' => 'newest', 'keyword' => '', 'desc' => 'NEW RELEASES']) }}">
              <span>View more</span><i class="bi bi-chevron-double-right"></i>
            </a>
          </div>
          <div class="trending-item-wrapper">
            @foreach ($newReleases as $index => $course)
              @if ($index % 3 == 0)
                <div class="trending-item-wrapper-column">
              @endif
              <a class="trending-item-inner" href="{{ route('course', ['slug' => $course->slug]) }}">
                <div class="trending-img">
                  <img src="{{ $course->thumbnail }}" alt="">
                </div>
                <div class="trending-content">
                  <h3 class="course-title">
                    {{ $course->name }}
                  </h3>
                  <div class="course-author">{{ $course->user->name }}</div>
                  <div class="course-price">
                    <span class="course-price-sale">{{ $course->discount }}$</span>
                    <span class="course-price-old">{{ $course->price }}$</span>
                  </div>
                </div>
              </a>
              @if ($index % 3 == 2)
          </div>
          @endif
          @endforeach
        </div>
        <div class="trending-dots">
          <span class="dot-active"></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="trending-item most-student">
        <div class="hot-topic-top">
          <h2>MOST POPULAR</h2>
          <a class="hot-topic-viewmore"
            href="{{ route('search', ['sort_by' => 'most-student', 'keyword' => '', 'desc' => 'MOST POPULAR']) }}">
            <span>View more</span><i class="bi bi-chevron-double-right"></i>
          </a>
        </div>
        <div class="trending-item-wrapper">
          @foreach ($mostPopular as $index => $course)
            @if ($index % 3 == 0)
              <div class="trending-item-wrapper-column">
            @endif
            <a class="trending-item-inner" href="{{ route('course', ['slug' => $course->slug]) }}">
              <div class="trending-img">
                <img src="{{ $course->thumbnail }}" alt="">
              </div>
              <div class="trending-content">
                <h3 class="course-title">
                  {{ $course->name }}
                </h3>
                <div class="course-author">{{ $course->user->name }}</div>
                <div class="course-price">
                  <span class="course-price-sale">{{ $course->discount }}$</span>
                  <span class="course-price-old">{{ $course->price }}$</span>
                </div>
              </div>
            </a>
            @if ($index % 3 == 2)
        </div>
        @endif
        @endforeach
      </div>
      <div class="trending-dots">
        <span class="dot-active"></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="trending-item vip-course">
      <div class="hot-topic-top">
        <h2>VIP COURSES</h2>
        <a class="hot-topic-viewmore"
          href="{{ route('search', ['sort_by' => 'newest', 'keyword' => '', 'desc' => 'VIP COURSES']) }}">
          <span>View more</span><i class="bi bi-chevron-double-right"></i>
        </a>
      </div>
      <div class="trending-item-wrapper">
        @foreach ($vipCourses as $index => $course)
          @if ($index % 3 == 0)
            <div class="trending-item-wrapper-column">
          @endif
          <a class="trending-item-inner" href="{{ route('course', ['slug' => $course->slug]) }}">
            <div class="trending-img">
              <img src="{{ $course->thumbnail }}" alt="">
            </div>
            <div class="trending-content">
              <h3 class="course-title">
                {{ $course->name }}
              </h3>
              <div class="course-author">{{ $course->user->name }}</div>
              <div class="course-price">
                <span class="course-price-sale">{{ $course->discount }}$</span>
                <span class="course-price-old">{{ $course->price }}$</span>
              </div>
            </div>
          </a>
          @if ($index % 3 == 2)
      </div>
      @endif
      @endforeach
    </div>
    <div class="trending-dots">
      <span class="dot-active"></span>
      <span></span>
      <span></span>
    </div>
    </div>
    </div>
    </div>

    <div class="hot-topic">
      <div class="hot-topic-top">
        <h2>BUSINESS AND STARTUP</h2>
        <a class="hot-topic-viewmore" href="{{ route('faculty', ['slug' => 'business-and-startup']) }}">
          <span>View more</span><i class="bi bi-chevron-double-right"></i>
        </a>
      </div>
      <div class="hot-topic-body" id="top-business">
        @foreach ($buisinessaAndStartup as $course)
          <a href="{{ route('course', ['slug' => $course->slug]) }}" class="course-item">
            <div class="slale-percent">-{{ $course->discountPercent() }}%</div>
            <div class="course-img">
              <img src="{{ $course->thumbnail }}" alt="">
            </div>
            <div class="course-wrapper">
              <h3 class="course-title">
                {{ $course->name }}
              </h3>
              <div class="course-author">{{ $course->user->name }}</div>
              <div class="course-review">
                <span class="course-point">{{ $course->byRate() }}</span>
                <span class="course-star">
                  {!! $course->getTemplStar($course->byRate()) !!}
                </span>
                <span class="course-review-count">({{ count($course->reviews) }})</span>
              </div>
              <div class="course-price">
                <span class="course-price-sale">{{ $course->discount }}$</span>
                <span class="course-price-old">{{ $course->price }}$</span>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>

    <div class="hot-topic">
      <h2 class="combo-h2">CONQUER YOUR GOAL</h2>
      <div class="combo">
        <div class="combo-row combo-row-2">
          <a class="combo-item"
            href="{{ route('combo.index', ['slug' => 'safety-and-effective-securities-investment-secrets']) }}">
            <div class="combo-img">
              <img src="{{ asset('images/stock-combo.jpg') }}" alt="" />
            </div>
            <div class="combo-wrapper">
              <div class="combo-title">
                <div class="combo-icon"><i class="bi bi-coin"></i></div>
                <div class="combo-desc">
                  <div class="combo-name">
                    PROFESSIONAL STOCK INVESTMENT
                  </div>
                  <div class="combo-count-course">2 courses</div>
                </div>
              </div>
            </div>
          </a>
          <a class="combo-item" href="{{ route('combo.index', ['slug' => 'sell-online-great-sale-increase-sales']) }}">
            <div class="combo-img">
              <img src="{{ asset('images/marketing-combo.jpg') }}" alt="" />
            </div>
            <div class="combo-wrapper">
              <div class="combo-title">
                <div class="combo-icon green">
                  <i class="bi bi-bank"></i>
                </div>
                <div class="combo-desc">
                  <div class="combo-name">
                    Professional stock investment
                  </div>
                  <div class="combo-count-course">2 courses</div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="combo-row combo-row-3">
          <a class="combo-item"
            href="{{ route('combo.index', ['slug' => 'practical-accounting-courses-on-excel-and-misa']) }}">
            <div class="combo-img">
              <img src="{{ asset('images/office-combo.jpg') }}" alt="" />
            </div>
            <div class="combo-wrapper">
              <div class="combo-title">
                <div class="combo-icon orange">
                  <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                </div>
                <div class="combo-desc">
                  <div class="combo-name">
                    Misa Excell Accounting Informatics Combo
                  </div>
                  <div class="combo-count-course">2 courses</div>
                </div>
              </div>
            </div>
          </a>
          <a class="combo-item" href="{{ route('combo.index', ['slug' => 'english-communication-courses']) }}">
            <div class="combo-img">
              <img src="{{ asset('images/social-combo.jpg') }}" alt="" />
            </div>
            <div class="combo-wrapper">
              <div class="combo-title">
                <div class="combo-icon pink">
                  <i class="bi bi-megaphone"></i>
                </div>
                <div class="combo-desc">
                  <div class="combo-name">
                    Confidently communicate in English
                  </div>
                  <div class="combo-count-course">2 courses</div>
                </div>
              </div>
            </div>
          </a>
          <a class="combo-item" href="{{ route('combo.index', ['slug' => 'easy-to-learn-korea']) }}">
            <div class="combo-img">
              <img src="{{ asset('images/korea-combo.jpg') }}" alt="" />
            </div>
            <div class="combo-wrapper">
              <div class="combo-title">
                <div class="combo-icon purple">
                  <i class="bi bi-translate"></i>
                </div>
                <div class="combo-desc">
                  <div class="combo-name">Korean Learning Combo</div>
                  <div class="combo-count-course">2 courses</div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="button-fa">
      <a href="{{ route('search') }}">View more</a>
    </div>

    <div class="hot-topic">
      <div class="catalog">
        <h2 class="catalog-h2">
          Haven't found the course you're interested in? <br />
          StarClasses has over 2,000 courses waiting for you to discover
        </h2>
        <div class="catalog-wrapper">
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'design']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/design.png') }}" alt="" />
            </div>
            <div class="catalog-name">Design</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'foreign-language']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/language.png') }}" alt="" />
            </div>
            <div class="catalog-name">Foreign language</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'marketing']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/marketing.png') }}" alt="" />
            </div>
            <div class="catalog-name">Marketing</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'business-and-startup']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/business.png') }}" alt="" />
            </div>
            <div class="catalog-name">Business and Startup</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'information-technology']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/computer.png') }}" alt="" />
            </div>
            <div class="catalog-name">Information Technology</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'office-informatics']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/office.png') }}" alt="" />
            </div>
            <div class="catalog-name">Office Informatics</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'marriage-and-family']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/marriage.png') }}" alt="" />
            </div>
            <div class="catalog-name">Marriage and Family</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'health-and-gender']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/heal.png') }}" alt="" />
            </div>
            <div class="catalog-name">Health and Gender</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'lifestyle']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/lifestyle.png') }}" alt="" />
            </div>
            <div class="catalog-name">Lifestyle</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'raise-up-child']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/family.png') }}" alt="" />
            </div>
            <div class="catalog-name">Raise up child</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'soft-skills']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/successful.png') }}" alt="" />
            </div>
            <div class="catalog-name">Self-development</div>
          </a>
          <a class="catalog-item" href="{{ route('faculty', ['slug' => 'sales']) }}">
            <div class="catalog-item-img">
              <img src="{{ asset('images/pie-chart.png') }}" alt="" />
            </div>
            <div class="catalog-name">Sales</div>
          </a>
        </div>
      </div>
    </div>
    <div class="hot-topic">
      <div class="hot-teacher">
        <h2 class="hot-teacher-h2">Typical teacher</h2>
        <div class="teacher-pre"><i class="bi bi-chevron-left"></i></div>
        <div class="teacher-next"><i class="bi bi-chevron-right"></i></div>
        <div class="teacher-box">
          <div class="teacher-wrapper">
            @foreach ($typicalTeacher as $user)
              <a class="teacher-item" href="{{ route('teacher', ['slug' => $user->slug]) }}">
                <div class="teacher-img">
                  <img src="{{ $user->thumbnail }}" alt="">
                </div>
                <div class="teacher-name">{{ $user->name }}</div>
                <div class="teacher-job">{{ $user->description }}</div>
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="hot-item-full">
      <div class="partner">
        <div class="parter-title">Become a teacher of Star Classes</div>
        <div class="parter-desc">
          More than 500 teachers have courses on Star Classes
        </div>
        <div class="button-fa button-big">
          <a href="{{ route('become.teacher') }}">Sign up now</a>
        </div>
      </div>
    </div>
    <!-- Chat with employee -->
    <div class="chat-icon">
      <i class="bi bi-chat-fill"></i>
    </div>
  </main>
  <!-- main - end -->
@endsection
@section('js')
  <script type="module" src="{{ asset('js/index.js') }}"></script>
@endsection
