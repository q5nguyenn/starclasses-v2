@php
  $active = 'user';
@endphp
@extends('admin.master')
@section('title')
  <title>User management</title>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">ADD USER</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame show" data-frame="0" novalidate enctype="multipart/form-data"
          action="{{ route('admin.user.store') }}" method="post">
          @csrf
          <div class="profile-frame-wrapper profile-frame-flex profile-frame-flex-mobile profile-frame-flex-gap">
            <div class="profile-frame-column">
              <div>Thumbnail</div>
              <label for="thumbnail" class="profile-frame-avatar" style="width:208px;">
                <img src="{{ asset('images/user.png') }}" alt="" />
                <span><i class="bi bi-camera-fill"></i></span>
              </label>
              <input type="file" id="thumbnail" accept="image/*" name="thumbnail" hidden />
              <div class="input-item-error">&nbsp;
                @error('thumbnail')
                  {{ $message }}
                @enderror
              </div>
              <label for="roles">Role</label>
              <div class="input-item">
                <select class="form-control js-example-tokenizer" multiple="multiple" name="roles[]" id="roles">
                  <option value=""></option>
                  @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>
                      {{ $role->name }}</option>
                  @endforeach
                </select>
                <div class="input-item-error">&nbsp;
                  @error('roles')
                    {{ $message }}
                  @enderror
                </div>
              </div>
              <label for="description">Description</label>
              <div class="input-item">
                <textarea name="description" id="description" class="input" style="height:150px">{{ old('description') }}</textarea>
                <span class="focus-input"></span>
              </div>
            </div>
            <div class="profile-frame-column">
              <label for="name">Name</label>
              <div class="input-item ">
                <input type="text" class="input" id="name" name="name" value="{{ old('name') }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('name')
                  {{ $message }}
                @enderror
              </div>
              <label for="email">Email</label>
              <div class="input-item ">
                <input type="text" class="input" id="email" name="email" value="{{ old('email') }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('email')
                  {{ $message }}
                @enderror
              </div>
              <label for="password">Password <small class="text-secondary">(default: 123456)</small></label>
              <div class="input-item ">
                <input type="password" class="input" id="password" name="password" value="123456" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
              </div>
              <label for="birth_day">Date of birth</label>
              <div class="input-item ">
                <input type="date" class="input" id="birth_day" name="birth_day" value="{{ old('birth_day') }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('birth_day')
                  {{ $message }}
                @enderror
              </div>
              <label for="phone_number">Phone number</label>
              <div class="input-item">
                <input type="number" class="input" id="phone_number" name="phone_number"
                  value="{{ old('phone_number') }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('phone_number')
                  {{ $message }}
                @enderror
              </div>
              <label for="province_id">Address</label>
              <div class="input-item">
                <select class="form-control js-example-tokenizer2" name="province_id" id="province_id">
                  <option value=""></option>
                  @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                      {{ $province->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="input-item-error">&nbsp;
                @error('province_id')
                  {{ $message }}
                @enderror
              </div>
              <button class="button-fa flex-right btn-update-user" type="submit" id="btn-add">Save</button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
@endsection
@section('js')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(".js-example-tokenizer2").select2({
      placeholder: 'Choose province',
    })
    $(".js-example-tokenizer").select2({
      placeholder: 'Select roles',
      tags: true,
      tokenSeparators: [',', ' ']
    })
  </script>
  {{-- Check Validate --}}
  <script src="{{ asset('js/admin/utilities.js') }}"></script>
  <script>
    previewUploadImage($('#thumbnail'), $('.profile-frame-avatar img'));
  </script>
@endsection
