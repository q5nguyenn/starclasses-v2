@php
  $active = 'chapter';
@endphp
@extends('admin.master')
@section('title')
  <title>Chapter Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/coursedesc.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
@endsection
@section('content')
  <div class="search-result" style="width:100%; padding-right: 8px">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">UPDATE CHAPTER</div>
    </div>
    <form class="profile-frame-flex profile-frame-width w-100" id="active-voucher" method="post"
      action="{{ route('admin.chapter.update', ['id' => $chapter->id]) }}">
      @csrf
      <label for="course_id_hidden">Course</label>
      <div class="input-item">
        <select class="form-select js-example-placeholder" aria-label="Default select example" name="course_id_hidden"
          id="course_id_hidden" disabled>
          <option value="">Select a course</option>
          @foreach ($courses as $course)
            <option value="{{ $course->id }}" {{ $chapter->course_id == $course->id ? 'selected' : '' }}>
              {{ $course->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="input-item d-none">
        <select class="form-select js-example-placeholder" aria-label="Default select example" name="course_id"
          id="course_id">
          <option value="">Select a course</option>
          @foreach ($courses as $course)
            <option value="{{ $course->id }}" {{ $chapter->course_id == $course->id ? 'selected' : '' }}>
              {{ $course->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="input-item-error">&nbsp;
        @error('course_id')
          {{ $message }}
        @enderror
      </div>
      <label for="content">Chapter name</label>
      <div class="input-item">
        <input type="text" class="input" id="content" name="content"
          value="{{ old('content', $chapter->content) }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('content')
          {{ $message }}
        @enderror
      </div>
      <label for="video_link">Video link</label>
      <div class="input-item">
        <input type="text" class="input" id="video_link" name="video_link"
          value="{{ old('video_link', $chapter->video_link) }}" />
        <span class="focus-input"></span>
        <div class="button-play-preview"><i class="bi bi-play"></i></div></a>
      </div>
      <div class="input-item-error">&nbsp;
        @error('video_link')
          {{ $message }}
        @enderror
      </div>
      <label for="parent_id">Choose the father of the chapter</label>
      <div class="input-item">
        <select class="form-select js-example-placeholder2" aria-label="Default select example" name="parent_id"
          id="parent_id">
          <option value=""></option>
          @foreach ($chapter_courses as $item)
            <option value="{{ $item->id }}"
              {{ $item->id == old('parent_id', $chapter->parent_id) ? 'selected' : '' }}>
              {{ $item->content }}</option>
          @endforeach
        </select>
      </div>
      <div class="input-item-error">&nbsp;
      </div>
      <button class="button-fa button-submit-form" type="submit">
        Update
      </button>
    </form>
    <!-- Video Popup -->
    <div class="video">
      <div class="video-container">
        <iframe width="956" height="538" src="" title="lofi hip hop radio - beats to relax/study to"
          frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>
    </div>
    <div class="video-blur"></div>
    <!-- Search box hiển thị kết quả tìm kiếm -->
  </div>
@endsection
@section('js')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(".js-example-placeholder").select2({
      placeholder: "Choose a course",
    })
    $(".js-example-placeholder2").select2({
      placeholder: "Choose a chapter",
    })
  </script>
  <script>
    $(document).ready(function() {
      $('.button-play-preview').click(function(e) {
        $('iframe').attr('src', "{{ $chapter->video_link }}");
        $('.video').show();
        $('.video-blur').show();
      });
      $('.video-blur').click(function(e) {
        $('.video').hide();
        $(this).hide();
      });
    });
  </script>
  <script src="{{ asset('js/coursedesc.js') }}"></script>
@endsection
