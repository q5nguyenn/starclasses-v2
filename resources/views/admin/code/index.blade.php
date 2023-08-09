@php
  $active = 'code';
@endphp
@extends('admin.master')
@section('title')
  <title>Code Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">CODE MANAGEMENT</div>
    </div>
    <div class="d-flex align-items-center justify-content-end">

      <form class="search-small d-flex" autocomplete="off" action="{{ route('admin.code.search') }}" id="search">
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}"
            placeholder="Search by name, course..." id="keyword">
          <a for="" class="search-small-delete-icon" href="{{ route('admin.code.search') }}"><i
              class="bi bi-x-lg"></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="{{ route('admin.code.create') }}">
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width:50px">#</th>
          <th scope="col">Code name</th>
          <th scope="col">Course</th>
          <th scope="col">Time</th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $code)
          <tr style="cursor: pointer;" data-url="{{ route('admin.code.edit', ['id' => $code->id]) }}" class="tb-row">
            <th scope="row">{{ $code->id }}</th>
            <td>{{ $code->name }}</td>
            <td>{{ $code->course->name }}</td>
            <td>{{ $code->time }}</td>
            <td class="text-end">
              <a href="{{ route('admin.code.delete', ['id' => $code->id]) }}" class="action-delete invisible"
                data-url="{{ route('admin.code.delete', ['id' => $code->id]) }}">
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
@endsection
