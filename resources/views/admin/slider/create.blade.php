@php
  $active = 'slider';
@endphp
@extends('admin.master')
@section('title')
  <title>Slider Management</title>
@endsection

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
@endsection

@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">ADD SLIDER</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame-flex profile-frame-width" id="active-voucher" novalidate method="post"
          enctype="multipart/form-data" action="{{ route('admin.slider.store') }}">
          @csrf
          <label for="thumbnail">Thumbnail</label>
          <div class="input-item">
            <label for="thumbnail" class="profile-frame-avatar" style="height : 300px">
              <img src="{{ asset('images/slider-default.jpg') }}" alt="" />
              <span><i class="bi bi-camera-fill"></i></span>
            </label>
            {{-- Thêm thuộc tính multiple để upload nhiều file --}}
            <input type="file" id="thumbnail" accept="image/*" name="thumbnail" hidden />
            <div class="input-item-error">&nbsp;
              @error('thumbnail')
                {{ $message }}
              @enderror
            </div>
          </div>
          <label for="course_id">Course</label>
          <div class="input-item">
            <select class="form-control js-example-tags" name="course_id" id="course_id">
              <option selected value=""></option>
              @foreach ($list as $course)
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
          <button class="button-fa button-active-voucher-mobile" type="submit">
            Save
          </button>
        </form>
        <div class="profile-frame-wrapper-title voucher-content"></div>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(".js-example-tags").select2({
      placeholder: "Choose a course"
    });
  </script>
  {{-- Check Validate --}}
  <script src="{{ asset('js/admin/utilities.js') }}"></script>
  <script>
    previewUploadImage($('#thumbnail'), $('.profile-frame-avatar img'));
  </script>
@endsection
