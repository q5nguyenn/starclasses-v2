@php
  $active = 'notification';
@endphp
@extends('admin.master')
@section('title')
  <title>Notification Management</title>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
    type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin/customFroala.css') }}" />
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">ADD NOTIFICATION</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame-flex profile-frame-width" id="active-voucher" novalidate method="post"
          action="{{ route('admin.notification.store') }}">
          @csrf
          <label for="users">To</label>
          <select class="form-select js-user-placeholder" multiple="multiple" aria-label="Default select example"
            name="users[]" id="users">
            <option value="">Select accounts</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}"
                {{ in_array($user->id, old('users', [$to_user->id ?? null])) ? 'selected' : '' }}>
                {{ $user->email }}
              </option>
            @endforeach
          </select>
          <div class="input-item-error">&nbsp;
            @error('users')
              {{ $message }}
            @enderror
          </div>
          <label for="title">Title</label>
          <div class="input-item">
            <input type="text" class="input" id="title" name="title" value="{{ old('title') }}">
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('title')
              {{ $message }}
            @enderror
          </div>
          <div class="input-item">
            <label for="description">Content</label>
            <textarea id="description" name="description" class="form-control" rows="3" placeholder="description" required>{{ old('description') }}</textarea>
            <div class="invalid-tooltip">This field is required</div>
            <div class="input-item-error">&nbsp;
              @error('description')
                {{ $message }}
              @enderror
            </div>
          </div>
          <button class="button-fa button-active-voucher-mobile" type="submit">
            Send
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
    $(".js-user-placeholder").select2({
      placeholder: 'Select accounts',
      tags: true,
      tokenSeparators: [',', ' ']
    })
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
  </script>
  <script>
    $(document).ready(function() {
      var editor = new FroalaEditor('#description');
    });
  </script>
@endsection
