@php
  // $page = ;
@endphp
@extends('master')
@section('title')
  <title>Star Classes - Search</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection
@section('main')
  <!-- main - start -->
  <main>
    <div class="search-wrapper">
      <div class="search-filter">
        <div class="search-filter-title">
          <i class="bi bi-sliders"></i> <span>Filter</span><button class="button-fa" id="clear-filter">Clear Filter</button>
        </div>
        <form action="{{ route('search.by') }}" id="filter" method="get">
          <input type="text" value="{{ $_GET['keyword'] ?? '' }}" name="keyword" id="keyword" hidden>
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
                <input type="radio" name="star" id="star1" value="4.5" {{ $star == 4.5 ? 'checked' : '' }} />
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
                <input type="radio" name="star" id="star2" value="4" {{ $star == 4 ? 'checked' : '' }} />
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
          @if ($desc == null)
            <div class="search-result-title">
              Search results for: " <span id="search-value">{{ $keyword }}</span>"
            </div>
          @else
            <div class="search-result-title-replace" style="display: block;">{{ $desc }}</div>
          @endif
          <div class="search-result-title-replace">Featured Course</div>
          <div class="search-count">
            <span class="search-count-value">{{ 0 < $count && $count < 10 ? '0' . $count : $count }}</span> results
            <span class="search-count-replace"> found</span>
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
                  <div class="search-result-name">{{ $course->name }}</div>
                  <div class="search-result-desc">
                    {{ $course->description }}
                  </div>
                  <div class="course-teacher-name">{{ $course->teacher_name }}</div>
                  <div class="course-students-count">
                    <i class="bi bi-people-fill"></i>
                    <span>{{ $course->students }}</span>
                  </div>
                  <div class="search-result-star">
                    <span>{{ round($course->star, 1) }}</span>
                    <span class="course-star">
                      <i class="bi bi-star-fill"></i>
                    </span>
                    <span>({{ $course->number_reviews }})</span>
                  </div>
                  <div class="search-result-time">
                    <span>04 hours total</span><i class="bi bi-dot"></i>
                    <span>Update {{ date('d/m/Y', strtotime($course->updated_at)) }}</span>
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
    let count = {{ $count }};
  </script>
  <script type="module" src="{{ asset('js/search.js') }}"></script>
@endsection
