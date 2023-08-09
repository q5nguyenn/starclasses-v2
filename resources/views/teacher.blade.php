@extends('master')
@section('title')
  <title>Star Classes - Teacher</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
@endsection
@section('main')
  <!-- main - start -->
  <main style="margin-top: 50px">
    <div class="teacher-top">
      <div class="teacher-wrapper teacher-wrapper-mobile">
        <div class="teacher-wrapper-top">
          <div class="teacher-avatar">
            <img src="{{ $user->thumbnail }}" alt="" />
          </div>
          <div class="teacher-info">
            <div class="teacher-info-item">
              <div class="teacher-info-count number-course">
                {{ count($user->courses) < 10 ? '0' . count($user->courses) : count($user->courses) }}
              </div>
              <div class="teacher-info-count-name">
                <i class="bi bi-book-fill"></i> Courses
              </div>
            </div>
            <div class="teacher-info-item">
              <div class="teacher-info-count number-student">{{ $user->students() }}</div>
              <div class="teacher-info-count-name">
                <i class="bi bi-people-fill"></i> Students
              </div>
            </div>
            <div class="teacher-info-item">
              <div class="teacher-info-count star-rate">{{ $user->byRate() }}</div>
              <div class="teacher-info-count-name">
                <span class="course-star">
                  <i class="bi bi-star-fill"></i>
                </span>
                Average rating
              </div>
            </div>
          </div>
        </div>
        <div class="teacher-name-box">
          <div class="teacher-name">{{ $user->name }}</div>
          <a class="teacher-social" href="https://vi-vn.facebook.com/">
            <i class="bi bi-facebook"></i>
          </a>
        </div>
        <div class="teacher-job">Teacher at: {{ $user->department()->name }}</div>
      </div>
    </div>
    <div class="teacher-body">
      <div class="teacher-box">
        <div class="teacher-box-colum" style="padding-right: 20px">
          <div class="teacher-box-colum-title">Introduce</div>
          <p class="teacher-box-colum-desc">
            <span class="teacher-name-inner">{{ $user->name }}</span>
            {{ $user->description }}
          </p>
        </div>
        <div class="teacher-box-colum">
          <div class="video-container">
            <iframe width="956" height="538" src="https://www.youtube.com/embed/jfKfPfyJRdk"
              title="lofi hip hop radio - beats to relax/study to" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>
          </div>
        </div>
      </div>
      <div class="teacher-box">
        <div class="teacher-box-colum-title">
          <span class="teacher-name-inner">{{ $user->name }}</span>'s courses
        </div>
      </div>
      <div class="teacher-box teacher-course">
        @foreach ($user->courses as $course)
          <a class="teacher-box-item" href="{{ route('course', ['slug' => $course->slug]) }}">
            <div class="teacher-box-item-img">
              <img src="{{ $course->thumbnail }}" alt="">
            </div>
            <div class="teacher-box-item-course">
              <div class="teacher-box-item-course-name">{{ $course->name }}</div>
              <div class="teacher-box-item-course-info">
                <span><i class="bi bi-list-stars"></i> 47 Lessons</span>
                <span><i class="bi bi-clock"></i> 07 hours 28 minutes</span>
              </div>
              <p class="teacher-box-item-course-desc">
                <i class="bi bi-check-lg"></i> Understand the basics of Take photo
              </p>
              <p class="teacher-box-item-course-desc">
                <i class="bi bi-check-lg"></i> Knowledge about Take photo is enhanced
              </p>
              <p class="teacher-box-item-course-desc">
                <i class="bi bi-check-lg"></i> Apply Take photo knowledge into practice
              </p>
            </div>
            <div class="teacher-box-item-cost">
              <div class="teacher-box-item-sale">{{ $course->discount }}$</div>
              <div class="teacher-box-item-old">{{ $course->price }}$</div>
              <div class="teacher-box-item-off">
                (OFF {{ number_format((($course->price - $course->discount) * 100) / $course->price) }}%)
              </div>
              <button class="button-fa">Detail</button>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </main>
  <!-- main - end -->
@endsection
