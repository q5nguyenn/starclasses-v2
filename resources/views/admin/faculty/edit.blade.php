@php
  $active = 'faculty';
@endphp
@extends('admin.master')
@section('title')
  <title>Faculty management</title>
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">UPDATE MANAGEMENT</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame-flex profile-frame-width" id="active-voucher" novalidate method="post"
          action="{{ route('admin.faculty.update', ['id' => $faculty->id]) }}">
          @csrf
          <label for="name">Faculty name</label>
          <div class="input-item">
            <input type="text" class="input" id="name" name="name"
              value="{{ old('name', $faculty->name) }}" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('name')
              {{ $message }}
            @enderror
          </div>
          <label for="icon">Icon
            <a href="https://icons.getbootstrap.com/" class="link-secondary" target="_blank"
              style="color: #ad5df0; text-decoration: underline;"><i class="bi bi-menu-app"></i>
              Get icon here
            </a>
          </label>
          <div class="input-item">
            <input type="text" class="input" id="icon" name="icon"
              value="{{ old('icon', $faculty->icon) }}" />
            <span class="focus-input"></span>
            <div class="icon-preview">{!! $faculty->icon !!}</div>
          </div>
          <div class="input-item-error">&nbsp;
            @error('icon')
              {{ $message }}
            @enderror
          </div>
          <button class="button-fa button-active-voucher-mobile" type="submit">
            Update
          </button>
        </form>
        <div class="profile-frame-wrapper-title voucher-content"></div>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script>
    $(document).ready(function() {
      $("[name=icon]").keyup(function(e) {
        let icon = $(this).val();
        console.log(icon);
        $('.icon-preview').html(icon);
      })
    });
  </script>
@endsection
