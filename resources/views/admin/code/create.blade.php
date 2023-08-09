@php
  $active = 'code';
@endphp
@extends('admin.master')
@section('title')
  <title>Code Management</title>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">ADD CODE</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame-flex profile-frame-width" novalidate method="post"
          action="{{ route('admin.code.store') }}">
          @csrf
          <label for="name">Code name</label>
          <div class="input-item">
            <input type="text" class="input" name="name" value="{{ old('name') }}" id="name" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('name')
              {{ $message }}
            @enderror
          </div>
          <label for="course_id">Course</label>
          <select class="form-select text-secondary js-course-placeholder-single" aria-label="Default select example"
            name="course_id" id="course_id">
            <option selected value="">Choose a course</option>
            @foreach ($listCourses as $item)
              <option value="{{ $item->id }}" {{ old('course_id') == $item->id ? 'selected' : '' }}>
                {{ $item->name }}</option>
            @endforeach
          </select>
          <div class="input-item-error">&nbsp;
            @error('course_id')
              {{ $message }}
            @enderror
          </div>
          <label for="time">Time</label>
          <div class="input-item">
            <input type="number" class="input" name="time" value="{{ old('time') }}" min="0"
              id="time" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('time')
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(".js-course-placeholder-single").select2({
      placeholder: "Choose a course",
    });
  </script>
@endsection
