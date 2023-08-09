@php
  $active = 'combo';
@endphp
@extends('admin.master')
@section('title')
  <title>Combo Management</title>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
    type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/admin/customFroala.css') }}" />
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">UPDATE COMBO</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame show" novalidate method="post"
          action="{{ route('admin.combo.update', ['id' => $combo->id]) }}">
          @csrf
          <div class="profile-frame-wrapper profile-frame-flex profile-frame-flex-mobile profile-frame-flex-gap">
            <div class="profile-frame-column">
              <label for="name">Combo name</label>
              <div class="input-item ">
                <input type="text" class="input" id="name" name="name"
                  value="{{ old('name', $combo->name) }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('name')
                  {{ $message }}
                @enderror
              </div>
              <label for="courses">Select courses</label>
              <div class="input-item">
                <select class="form-select js-example-placeholder2" multiple name="courses[]" id="courses">
                  <option value=""></option>
                  @foreach ($courses as $course)
                    <option value="{{ $course->id }}"
                      {{ in_array($course->id, old('courses', $combo->courses->pluck('id')->toArray())) ? 'selected' : '' }}>
                      {{ $course->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="input-item-error">&nbsp;
                @error('courses')
                  {{ $message }}
                @enderror
              </div>
            </div>
            <div class="profile-frame-column">
              <label for="price">Combo price</label>
              <div class="input-item ">
                <input type="number" class="input" id="price" name="price" min="0"
                  value="{{ old('price', $combo->price) }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('price')
                  {{ $message }}
                @enderror
              </div>
              <label for="expiration_date">Expiration date</label>
              <div class="input-item ">
                <input type="date" class="input" id="expiration_date" name="expiration_date"
                  value="{{ old('expiration_date', $combo->expiration_date) }}" />
                <span class="focus-input"></span>
              </div>
              <div class="input-item-error">&nbsp;
                @error('expiration_date')
                  {{ $message }}
                @enderror
              </div>
            </div>
          </div>
          <div class="profile-frame-wrapper">
            <div class="input-item">
              <label for="problem_solving">Problem solving</label>
              <textarea id="problem_solving" name="problem_solving" class="form-control" rows="3" required>
								{{ old('problem_solving', $combo->problem_solving) }}
							</textarea>
              <div class="invalid-tooltip">This field is required</div>
              <div class="input-item-error">&nbsp;
                @error('problem_solving')
                  {{ $message }}
                @enderror
              </div>
            </div>
            <div class="input-item">
              <label for="introduce">Introduce</label>
              <textarea id="introduce" name="introduce" class="form-control" rows="3" required>
								{{ old('introduce', $combo->introduce) }}
							</textarea>
              <div class="invalid-tooltip">This field is required</div>
              <div class="input-item-error">&nbsp;
                @error('introduce')
                  {{ $message }}
                @enderror
              </div>
            </div>
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
    $(".js-example-placeholder2").select2({
      placeholder: "Select courses"
    })
  </script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
  </script>
  <script>
    $(document).ready(function() {
      var editor = new FroalaEditor('#problem_solving');
      var editor = new FroalaEditor('#introduce');
    });
  </script>
@endsection
