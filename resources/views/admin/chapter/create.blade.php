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
      <div class="profile-frame-title">ADD CHAPTER</div>
    </div>
    <form class="profile-frame-flex profile-frame-width w-100" id="active-voucher" novalidate method="post"
      action="{{ route('admin.chapter.store') }}">
      @csrf
      <label for="course_id">Choose a course</label>
      <div class="input-item">
        <select class="form-select js-example-placeholder" aria-label="Default select example" name="course_id"
          id="course_id">
          <option value="">Choose a course</option>
          @foreach ($courses as $course)
            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
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
        <input type="text" class="input" id="content" name="content" value="{{ old('content') }}" />
        <span class="focus-input"></span>
      </div>
      <div class="input-item-error">&nbsp;
        @error('content')
          {{ $message }}
        @enderror
      </div>
      <label for="video_link">Video link</label>
      <div class="input-item">
        <input type="text" class="input" id="video_link" name="video_link" value="{{ old('video_link') }}" />
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
        </select>
      </div>
      <div class="input-item-error">&nbsp;
      </div>
      <button class="button-fa button-submit-form" type="submit">
        Save
      </button>
    </form>
    <!-- Video Popup -->
    <div class="video">
      <div class="video-container">
        <iframe width="956" height="538" src="https://www.youtube.com/embed/jfKfPfyJRdk"
          title="lofi hip hop radio - beats to relax/study to" frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
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
    $('.js-example-placeholder').change(function(e) {
      id = $(this).val();
      console.log(id);
      let urlRequest = "{{ route('admin.chapter.show') }}" + "?id=" + id;
      let htmlResult = `<option value=""></option>`;
      $.ajax({
        type: "get",
        url: urlRequest,
        success: function(response) {
          console.log(response);
          response.forEach(item => {
            if (item['parent_id'] == 0) {
              htmlResult +=
                `<option value="${item['id']}" class="chapter-parent" style="color:red">${item['content']}</option>`;
              response.forEach(item2 => {
                if (item2['parent_id'] == item['id']) {
                  htmlResult +=
                    `<option value="${item2['id']}" class="chapter-parent" style="color:red">${item2['content']}</option>`;
                }
              });
            }
          });
          $('.js-example-placeholder2').html(htmlResult);
        }
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.button-play-preview').click(function(e) {
        $('iframe').attr('src', $('[name=video_link]').val());
        $('.video').show();
        $('.video-blur').show();
      });
      $('.video-blur').click(function(e) {
        $('.video').hide();
        $(this).hide();
      });
    });
  </script>
  <script src="{{ asset('js/admin/coursedesc.js') }}"></script>
@endsection
