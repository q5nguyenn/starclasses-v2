@php
  $active = 'review';
@endphp
@extends('admin.master')
@section('title')
  <title>Review Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">REVIEW MANAGEMENT</div>
    </div>
    <div class="float-end d-flex align-items-center">
      {{-- <div class="search-small-result">{{ $count }} kết quả</div> --}}
      <form class="search-small d-flex" autocomplete="off" action="{{ route('admin.review.search') }}" id="search">
        <div class="input-item d-flex me-2">
          <select class="form-select text-secondary" aria-label="Default select example" name="status">
            <option selected value="">Choose a status</option>
            <option value="1" {{ ($status ?? '') == '1' ? 'selected' : '' }}>Ok</option>
            <option value="0" {{ ($status ?? '') == '0' ? 'selected' : '' }}>Report</option>
            <option value="2" {{ ($status ?? '') == '2' ? 'selected' : '' }}>Hide</option>
          </select>
        </div>
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}" style="width:360px"
            placeholder="Search by user, course name..." id="keyword">
          <a for="" class="search-small-delete-icon" href="{{ route('admin.review.search') }}"><i
              class="bi bi-x-lg"></i></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="{{ route('admin.review.create') }}">
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 50px">#</th>
          <th scope="col" style="width: 250px">User</th>
          <th scope="col">Content</th>
          <th scope="col" style="width: 0px">Rate</th>
          <th scope="col">Course</th>
          <th scope="col" style="width: 0px">Status</th>
          <th scope="col" class="text-center" style="width: 00px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $review)
          <tr style="cursor: pointer;" data-url="{{ route('admin.review.edit', ['id' => $review->id]) }}" class="tb-row">
            <th scope="row">{{ $review->id }}</th>
            <td>{{ $review->user->email }}</td>
            <td>{{ $review->content }}</td>
            <td>{{ $review->rate }}</td>
            <td>{{ $review->course->name }}</td>
            <td>{!! $review->status == 0
                ? '<i class="bi bi-exclamation-square text-warning fs-5"></i>'
                : ($review->status == 1
                    ? '<i class="bi bi-check-square fs-5 text-success"></i>'
                    : '<i class="bi bi-x-square fs-5 text-danger"></i>') !!}</td>
            <td class="text-end">
              {{-- <a href="{{ route('admin.review.edit', ['id' => $review->id]) }}">
						<button class="button-edit" >
							<i class="bi bi-pencil"></i>
						</button>
					</a> --}}
              <a href="{{ route('admin.review.delete', ['id' => $review->id]) }}" class="action-delete invisible"
                data-url="{{ route('admin.review.delete', ['id' => $review->id]) }}">
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
    $('[name="status"]').change(function(e) {
      $('#search').submit();
    });
  </script>
@endsection
