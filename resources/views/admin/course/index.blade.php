@php
  $active = 'course';
@endphp
@extends('admin.master')
@section('title')
  <title>Course management</title>
@endsection
@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/coursedesc.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">COURSE MANAGEMENT</div>
    </div>
    <div class="d-flex align-items-center justify-content-end">
      {{-- <div class="search-small-result">{{ $count }} kết quả</div> --}}
      <form class="search-small d-flex" autocomplete="off" action="{{ route('admin.course.search') }}" id="search">
        <div class="input-item d-flex me-2">
          <select class="js-faculty form-select text-secondary" aria-label="Default select example" name="faculty_id"
            style="width:250px">
            <option selected value="">Choose a faculty</option>
            @foreach ($listFaculties as $item)
              <option value="{{ $item->id }}" {{ $item->id == ($faculty_id ?? 0) ? 'selected' : '' }}>
                {{ $item->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="input-item d-flex me-2">
          <select class="js-department form-control" aria-label="Default select example" name="department_id"
            id="department_id" style="width:250px">
            <option value="" selected></option>
            @foreach ($listDepartments as $department)
              <option value="{{ $department->id }}" {{ $department->id == ($department_id ?? 0) ? 'selected' : '' }}>
                {{ $department->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}"
            placeholder="Search by name, teacher..." style="width:360px" id="keyword">
          <a for="" class="search-small-delete-icon" href="{{ route('admin.course.search') }}"><i
              class="bi bi-x-lg"></i></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="{{ route('admin.course.create') }}" class="d-flex">
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>
    <div class="course-relevant-box">
      @foreach ($list as $course)
        <div class="course-relevant-item tb-row" style="cursor: pointer;"
          data-url="{{ route('admin.course.edit', ['id' => $course->id]) }}">
          <div class="course-relevant-img">
            <img src="{{ $course->thumbnail }}" alt="">
          </div>
          <div class="course-relevant-wrapper">
            <div class="course-relevant-info">
              <div class="course-relevant-name flex-shrink-0">{{ $course->name }} <small
                  class="fw-normal text-secondary">#{{ $course->id }}</small>
              </div>
              <div class="course-relevant-time flex-shrink-0">
                <span>{{ $course->user->name }}</span><i class="bi bi-dot"></i>
                <span>{{ date('d/m/Y', strtotime($course->updated_at)) }}</span>
              </div>
            </div>
            <div class="course-relevant-star text-danger ">
              <span class="text-truncate"> </span>
              <span class="course-star">
                {{-- {!! $course->department->faculty->icon  !!} --}}
              </span>
            </div>
            <div class="course-students-count text-end">
              {!! $course->department->faculty->icon !!}
              <span>{{ $course->department->name }}</span>
            </div>
            <div class="course-relevant-price">
              <div>{{ $course->discount }}$</div>
              <div>{{ $course->price }}$</div>
            </div>
            <a href="{{ route('admin.course.delete', ['id' => $course->id]) }}" class="action-delete invisible"
              data-url="{{ route('admin.course.delete', ['id' => $course->id]) }}">
              <button class="button-delete">
                <i class="bi bi-trash3"></i>
              </button>
            </a>
          </div>
        </div>
      @endforeach
    </div>
    {{ $list->appends(['keyword' => $keyword ?? ''])->links() }}
  </div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="{{ asset('js/admin/index.js') }}"></script>
  <script>
    $(".js-department").select2({
      placeholder: "Choose a department",
      // allowClear: true
    });

    $(".js-faculty").select2({
      placeholder: "Choose a faculty",
      // allowClear: true
    });
  </script>
  <script>
    $('[name="faculty_id"]').change(function(e) {
      $('#search').submit();
    });
    $('[name="department_id"]').change(function(e) {
      $('#search').submit();
    });
  </script>
@endsection
