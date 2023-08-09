@php
  $active = 'review';
@endphp
@extends('admin.master')
@section('title')
  <title>Review Management</title>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">ADD MANAGEMENT</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame-flex profile-frame-width" id="active-voucher" novalidate method="post"
          action="{{ route('admin.review.store') }}">
          @csrf
          <label for="user_id">Account</label>
          <select class="form-select js-example-placeholder" aria-label="Default select example" name="user_id"
            id="user_id">
            <option selected value="">Choose an account</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->email }}
              </option>
            @endforeach
          </select>
          <div class="input-item-error">&nbsp;
            @error('user_id')
              {{ $message }}
            @enderror
          </div>
          <label for="content">Content</label>
          <div class="input-item">
            <textarea name="content" id="content" class="input" style="height:100px">{{ old('content') }}</textarea>
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('content')
              {{ $message }}
            @enderror
          </div>
          <label for="course_id">Course</label>
          <select class="form-select js-example-placeholder2" aria-label="Default select example" name="course_id"
            id="course_id">
            <option value="">Choose a course</option>
            @foreach ($courses as $course)
              <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                {{ $course->name }}</option>
            @endforeach
          </select>
          <div class="input-item-error">&nbsp;
            @error('course_id')
              {{ $message }}
            @enderror
          </div>
          <label for="rate">Rate</label>
          <select class="form-select" aria-label="Default select example" name="rate" id="rate">
            <option value="" selected>Choose number of stars</option>
            @for ($i = 1; $i <= 5; $i++)
              <option value="{{ $i }}" {{ old('rate') == $i ? 'selected' : '' }}>{{ $i }} star
              </option>
            @endfor
          </select>
          <div class="input-item-error">&nbsp;
            @error('rate')
              {{ $message }}
            @enderror
          </div>
          <label for="status">Status</label>
          <select class="form-select" aria-label="Default select example" name="status" id="status">
            <option value='' selected>Choose a status</option>
            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Ok</option>
            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Report</option>
            <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Hide</option>
          </select>
          <div class="input-item-error">&nbsp;
            @error('status')
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
    $(".js-example-placeholder").select2({
      placeholder: "Choose a course"
    })

    $(".js-example-placeholder2").select2({
      placeholder: "Choose an account"
    })
  </script>
@endsection
