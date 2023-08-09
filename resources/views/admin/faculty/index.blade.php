@php
  $active = 'faculty';
@endphp
@extends('admin.master')
@section('title')
  <title>Faculty management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">FACULTY MANAGEMENT</div>
    </div>
    <div class="float-end d-flex align-items-center">
      {{-- <div class="search-small-result">{{ $count }} kết quả</div> --}}
      <form class="search-small" autocomplete="off" action="{{ route('admin.faculty.search') }}" id="search">
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Search by name..."
            id="keyword">
          <a for="" class="search-small-delete-icon" href="{{ route('admin.faculty.search') }}"><i
              class="bi bi-x-lg"></i></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="{{ route('admin.faculty.create') }}">
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 50px">#</th>
          <th scope="col">Faculty name</th>
          <th scope="col" style="width: 50px">Icon</th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @php
          $page = $_GET['page'] ?? 1;
        @endphp
        @foreach ($list as $faculty)
          <tr style="cursor: pointer;" data-url="{{ route('admin.faculty.edit', ['id' => $faculty->id]) }}"
            class="tb-row">
            <th scope="row">{{ $loop->index + 1 + ($page - 1) * 10 }}</th>
            <td>{{ $faculty->name }}</td>
            <td style="font-size: 22px">{!! $faculty->icon !!}</td>
            <td class="text-end">
              <a href="{{ route('admin.faculty.delete', ['id' => $faculty->id]) }}"
                data-url="{{ route('admin.faculty.delete', ['id' => $faculty->id]) }}" class="action-delete invisible">
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
