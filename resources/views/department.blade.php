@extends('master')
@section('title')
  <title>Star Classes - Department</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/tag.css') }}">
  <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection
@section('main')
  <!-- main - start -->
  <main>
    <div class="search-top-tag">
      <div class="search-top-tag-wrapper">
        <div class="course-tree">
          <span>Star Classes</span><i class="bi bi-chevron-double-right"></i>
          <a id="section" href="{{ route('faculty', ['slug' => $department->faculty->slug]) }}" id="section">
            {{ $department->faculty->name }}
          </a>
          <i class="bi bi-chevron-double-right"></i>
          <a id="subject" href="{{ route('department', ['slug' => $department->slug]) }}" id="subject">
            {{ $department->name }}
          </a>
        </div>
      </div>
    </div>
    <div class="search-wrapper">
      <div class="search-wrapper-title"></div>
    </div>
    <div class="search-wrapper flex-column search-wrapper-frame">
      <div class="tag-menu">
        <div class="tag-menu-item tag-is-active" data-filter="student">
          Most popular
        </div>
        <div class="tag-menu-item" data-filter="update">Newest</div>
      </div>
      <div class="teacher-pre"><i class="bi bi-chevron-left"></i></div>
      <div class="teacher-next"><i class="bi bi-chevron-right"></i></div>
      <div class="course-frame-wrapper">
        <div class="course-frame course-frame-tag" id="most-popular">
          @foreach ($mostPopular as $course)
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
        <div class="course-frame course-frame-tag" id="newest" style="display: none">
          @foreach ($newest as $course)
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
    </div>
    <div class="search-wrapper"></div>
    <div class="popular-tag">
      <div class="popular-tag-title">Popular topics</div>
      <div class="popular-tag-wrapper">
        @foreach ($department->faculty->departments as $item)
          <a class="popular-tag-item" href="{{ route('department', ['slug' => $item->slug]) }}">{{ $item->name }}</a>
        @endforeach
      </div>
    </div>
    <div class="search-wrapper search-wrapper-tag">
      <div class="search-filter">
        <div class="search-filter-title">
          <i class="bi bi-sliders"></i> <span>Filter</span><button class="button-fa" id="clear-filter"
            data-clear="{{ route('department', ['slug' => $department->slug]) }}">Clear Filter</button>
        </div>
        <form action="{{ route('department.sort', ['slug' => $department->slug]) }}" id="filter" method="get">
          <input type="number" value="{{ $_GET['page'] ?? 0 }}" name="page" id="page" hidden>
          <!-- item 1 -->
          <div class="search-item">
            <div class="search-item-title">
              <span>Sort by</span> <i class="bi bi-chevron-up"></i>
            </div>
            <div class="search-item-wrapper search-item-show">
              <div class="search-item-inner">
                <input type="radio" name="sort_by" id="sort1" value="most-student"
                  {{ $sort_by == 'most-student' ? 'checked' : '' }} />
                <label for="sort1" class="radio"></label>
                <label for="sort1">
                  <span>Most students</span>
                </label>
              </div>
              <div class="search-item-inner">
                <input type="radio" name="sort_by" id="sort2" value="most-star"
                  {{ $sort_by == 'most-star' ? 'checked' : '' }} />
                <label for="sort2" class="radio"></label>
                <label for="sort2">
                  <span>Most stars</span>
                </label>
              </div>
              <div class="search-item-inner">
                <input type="radio" name="sort_by" id="sort3" value="newest"
                  {{ $sort_by == 'newest' ? 'checked' : '' }} />
                <label for="sort3" class="radio"></label>
                <label for="sort3">
                  <span>Newest</span>
                </label>
              </div>
            </div>
          </div>
          <!-- item 2 -->
          <div class="search-item">
            <div class="search-item-title">
              <span>Price</span> <i class="bi bi-chevron-up"></i>
            </div>
            <div class="search-item-wrapper search-item-show">
              <div class="search-item-inner">
                <input type="radio" name="sort_by" id="price1" value="price-desc"
                  {{ $sort_by == 'price-desc' ? 'checked' : '' }} />
                <label for="price1" class="radio"></label>
                <label for="price1">
                  <span>From high to low</span>
                </label>
              </div>
              <div class="search-item-inner">
                <input type="radio" name="sort_by" id="price2" value="price-asc"
                  {{ $sort_by == 'price-asc' ? 'checked' : '' }} />
                <label for="price2" class="radio"></label>
                <label for="price2">
                  <span>From low to high</span>
                </label>
              </div>
            </div>
          </div>
          <!-- item 3 -->
          <div class="search-item">
            <div class="search-item-title">
              <span>Ratings</span> <i class="bi bi-chevron-up"></i>
            </div>
            <div class="search-item-wrapper search-item-show">
              <div class="search-item-inner">
                <input type="radio" name="star" id="star1" value="4.5"
                  {{ $star == 4.5 ? 'checked' : '' }} />
                <label for="star1" class="radio"></label>
                <label for="star1">
                  <span class="course-star">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                      class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                  </span>
                  <span>4.5 & up</span>
                </label>
              </div>
              <div class="search-item-inner">
                <input type="radio" name="star" id="star2" value="4"
                  {{ $star == 4 ? 'checked' : '' }} />
                <label for="star2" class="radio"></label>
                <label for="star2">
                  <span class="course-star">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                      class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                  </span>
                  <span>4.0 & up</span>
                </label>
              </div>
              <div class="search-item-inner">
                <input type="radio" name="star" id="star3" value="3.5"
                  {{ $star == 3.5 ? 'checked' : '' }} />
                <label for="star3" class="radio"></label>
                <label for="star3">
                  <span class="course-star">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                      class="bi bi-star-half"></i><i class="bi bi-star"></i>
                  </span>
                  <span>3.5 & up</span>
                </label>
              </div>
              <div class="search-item-inner">
                <input type="radio" name="star" id="star4" value="3"
                  {{ $star == 3 ? 'checked' : '' }} />
                <label for="star4" class="radio"></label>
                <label for="star4">
                  <span class="course-star">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                      class="bi bi-star"></i><i class="bi bi-star"></i>
                  </span>
                  <span>3.0 & up</span>
                </label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="search-result">
        <div class="search-result-top">
          <div class="search-result-title" style="display: none">
            <span id="search-value"></span>
          </div>
          <div class="search-result-title-replace"></div>
          <div class="search-count">
            <span class="search-count-value"></span>
            {{ count($department->courses) < 10 ? '0' . count($department->courses) : count($department->courses) }}
            courses
            <span class="search-count-replace"></span>
          </div>
        </div>
        <!-- Kết quả tìm kiếm -->
        <div class="search-result-display">
          @foreach ($courses as $course)
            <a class="search-result-item" href="{{ route('course', ['slug' => $course->slug]) }}">
              <div class="search-result-img">
                <img src="{{ $course->thumbnail }}" alt="">
              </div>
              <div class="search-result-wrapper">
                <div class="search-result-info">
                  <div class="search-result-name">{{ $course->name }}
                  </div>
                  <div class="search-result-desc">
                    {{ $course->description }}
                  </div>
                  <div class="course-teacher-name">{{ $course->author }}</div>
                  <div class="course-students-count">
                    <i class="bi bi-people-fill"></i>
                    <span>{{ count($course->bills) }}</span>
                  </div>
                  <div class="search-result-star">
                    <span>{{ $course->byRate() }}</span>
                    <span class="course-star">
                      <i class="bi bi-star-fill"></i>
                    </span>
                    <span>({{ count($course->reviews) }})</span>
                  </div>
                  <div class="search-result-time">
                    <span>05 hours total</span><i class="bi bi-dot"></i>
                    <span>Update 5/10/2022</span>
                  </div>
                </div>
                <div class="search-result-price">
                  <div>{{ $course->discount }}$</div>
                  <div>{{ $course->price }}$</div>
                </div>
              </div>
            </a>
          @endforeach
        </div>
        <!--  -->
        @if ($view_more)
          <!--  -->
          <div class="search-view-more">
            <button class="button-fa" id="view-more">Show more
            </button>
          </div>
        @endif
      </div>
    </div>
  </main>
  <!-- main - end -->
@endsection
@section('js')
  <script>
    let mostPopular = {{ count($mostPopular) }};
    let count = {{ $count }};
    let department_slug = '{{ $department->slug }}';
  </script>
  <script type="module" src="{{ asset('js/department.js') }}"></script>
@endsection
