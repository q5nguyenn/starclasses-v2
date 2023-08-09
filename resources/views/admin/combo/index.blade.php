@php
  $active = 'combo';
  $total_discount = 0;
@endphp
@extends('admin.master')
@section('title')
  <title>Combo Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">COMBO MANAGEMENT</div>
    </div>
    <div class="d-flex align-items-center justify-content-end">
      {{-- <div class="search-small-result">{{ $count }} results</div> --}}
      <form class="search-small d-flex" autocomplete="off" action="{{ route('admin.combo.search') }}" id="search">
        <div class="input-item d-flex me-2">
          {{-- <select class="form-select text-secondary" aria-label="Default select example" name="sort_by">
            <option selected value="">Sort by</option>
            <option value="newest" {{ ($sort_by ?? '') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ ($sort_by ?? '') == 'oldest' ? 'selected' : '' }}>Oldest</option>
          </select> --}}
        </div>
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Search by name..."
            style="width: 360px" id="keyword">
          <a for="" class="search-small-delete-icon" href="{{ route('admin.combo.search') }}"><i
              class="bi bi-x-lg"></i></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="{{ route('admin.combo.create') }}">
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width:50px">#</th>
          <th scope="col">Name</th>
          <th scope="col">Courses</th>
          <th scope="col" style="width:150px">Price</th>
          {{-- <th scope="col">Price</th> --}}
          <th scope="col" style="width:150px">Expiration date</th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $combo)
          <tr style="cursor: pointer;" data-url="{{ route('admin.combo.edit', ['id' => $combo->id]) }}" class="tb-row">
            <th scope="row">{{ $combo->id }}</th>
            <th>{{ $combo->name }}</th>
            <td>
              @foreach ($combo->courses as $course)
                <div>{{ $course->name }}</div>
              @endforeach
            </td>
            <td>{{ $combo->price }}</td>
            <td>{{ $combo->expiration_date }}</td>
            <td class="text-end">
              <a href="{{ route('admin.combo.delete', ['id' => $combo->id]) }}" class="action-delete invisible"
                data-url="{{ route('admin.combo.delete', ['id' => $combo->id]) }}">
                <button class="button-delete">
                  <i class="bi bi-trash3"></i>
                </button>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $list->appends(['keyword' => $keyword ?? ''])->links() }}
  </div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/admin/index.js') }}"></script>
  <script>
    $('[name="sort_by"]').change(function(e) {
      $('#search').submit();
    });
  </script>
@endsection
