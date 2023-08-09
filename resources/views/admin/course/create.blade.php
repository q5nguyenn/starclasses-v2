@php
  $active = 'course';
@endphp
@extends('admin.master')
@section('title')
  <title>Course management</title>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
    type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/admin/customFroala.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">ADD COURSE</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame show" data-frame="0" enctype="multipart/form-data"
          action="{{ route('admin.course.store') }}" method="post" novalidate>
          @csrf
          <div class="profile-frame-wrapper profile-frame-flex profile-frame-flex-mobile profile-frame-flex-gap">
            <div class="profile-frame-column">
              <div>Thumbnail</div>
              <label for="choose-avatar" class="profile-frame-avatar">
                <img src="{{ asset('images/slide-default.jpg') }}" alt="" id="avatar" />
                <span><i class="bi bi-camera-fill"></i></span>
              </label>
              <input type="file" id="choose-avatar" accept="image/*" name="thumbnail" value="{{ old('thumbnail') }}" />
              <div class="input-item-error">&nbsp;
                @error('thumbnail')
                  {{ $message }}
                @enderror
              </div>
              <div class="input-item-error"></div>
              <label for="description">Short description</label>
              <div class="input-item input-item-bottom">
                <textarea name="description" id="description" class="input" style="height:150px">{{ old('description') }}</textarea>
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('description')
                  {{ $message }}
                @enderror
              </div>
            </div>
            <div class="profile-frame-column">
              <label for="name">Course name</label>
              <div class="input-item input-item-bottom">
                <input type="text" class="input" id="name" name="name" value="{{ old('name') }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('name')
                  {{ $message }}
                @enderror
              </div>
              <label for="price">Price</label>
              <div class="input-item input-item-bottom">
                <input type="number" class="input" id="price" name="price" value="{{ old('price') }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('price')
                  {{ $message }}
                @enderror
              </div>
              <label for="discount">Discount</label>
              <div class="input-item input-item-bottom">
                <input type="number" class="input" id="discount" name="discount" value="{{ old('discount') }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('discount')
                  {{ $message }}
                @enderror
              </div>
              <label for="department_id">Department</label>
              <select class="js-department-placeholder-single form-control" aria-label="Default select example"
                name="department_id" id="department_id">
                <option></option>
                @foreach ($listDepartments as $department)
                  <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}</option>
                @endforeach
              </select>
              <div class="input-item-error">&nbsp;
                @error('department_id')
                  {{ $message }}
                @enderror
              </div>
              <label for="tags">Tags</label>
              <select class="form-control js-example-tokenizer" multiple="multiple" name="tags[]" id="tags">
                @foreach ($listTags as $tag)
                  <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                    {{ $tag->name }}</option>
                @endforeach
              </select>
              <div class="input-item-error">&nbsp;
              </div>
            </div>
          </div>
          <div class="profile-frame-wrapper">
            <div class="input-item">
              <label for="learn">What you will learn</label>
              <textarea id="learn" name="learn" class="form-control" rows="3" required>{{ old('learn') }}</textarea>
              <div class="invalid-tooltip">This field is required</div>
              <div class="input-item-error">&nbsp;
                @error('learn')
                  {{ $message }}
                @enderror
              </div>
            </div>
            <div class="input-item">
              <label for="introduction">Course introduction</label>
              <textarea id="introduction" name="introduction" class="form-control" rows="3" required>{{ old('introduction') }}</textarea>
              <div class="invalid-tooltip">This field is required</div>
              <div class="input-item-error">&nbsp;
                @error('introduction')
                  {{ $message }}
                @enderror
              </div>
            </div>
          </div>
          <button class="button-fa flex-right btn-update-user" id="btn-add">Save</button>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(".js-example-tokenizer").select2({
      tags: true,
      tokenSeparators: [',', ' ']
    })

    $(".js-department-placeholder-single").select2({
      placeholder: "Choose a department",
      // allowClear: true
    });

    $(".js-teacher-placeholder-single").select2({
      placeholder: "Choose an account ",
      // allowClear: true
    });
  </script>
  {{-- Preview image upload --}}
  <script src="{{ asset('js/admin/utilities.js') }}"></script>
  <script>
    previewUploadImage($('#choose-avatar'), $('.profile-frame-avatar img'));
  </script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
  </script>
  <script>
    var editor = new FroalaEditor('#learn');
    var editor = new FroalaEditor('#introduction');
  </script>
@endsection
