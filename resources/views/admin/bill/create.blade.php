@php
  $active = 'bill';
@endphp
@extends('admin.master')
@section('title')
  <title>Bill Management</title>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">ADD BILL</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame-flex profile-frame-width" id="active-voucher" novalidate method="post"
          action="{{ route('admin.bill.store') }}">
          @csrf
          <label for="user_id">User</label>
          <div class="input-item">
            <select class="form-select js-example-placeholder" name="user_id" id="user_id">
              <option value=""></option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                  {{ $user->email }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="input-item-error">&nbsp;
            @error('user_id')
              {{ $message }}
            @enderror
          </div>
          <label for="courses">Select courses to buy</label>
          <div class="input-item">
            <select class="form-select js-example-placeholder2" multiple name="courses[]" id="courses">
              <option value=""></option>
              @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ in_array($course->id, old('courses', [])) ? 'selected' : '' }}>
                  {{ $course->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="input-item-error">&nbsp;
            @error('courses')
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
      placeholder: "Choose an account"
    })
    $(".js-example-placeholder2").select2({
      placeholder: "Select courses"
    })
  </script>
@endsection
