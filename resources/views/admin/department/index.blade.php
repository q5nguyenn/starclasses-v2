@php
  $active = 'department';
@endphp
@extends('admin.master')
@section('title')
  <title>Department Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">DEPARTMENT MANAGEMENT</div>
    </div>
    <div class="d-flex align-items-center justify-content-end">
      {{-- <div class="search-small-result">{{ $count }} kết quả</div> --}}
      <form class="search-small d-flex" autocomplete="off" action="{{ route('admin.department.search') }}" id="search">
        <div class="input-item d-flex me-2">
          <select class="form-select text-secondary" aria-label="Default select example" name="faculty_id">
            <option selected value="">Choose a faculty</option>
            @foreach ($listFaculties as $item)
              <option value="{{ $item->id }}" {{ $item->id == ($faculty_id ?? 0) ? 'selected' : '' }}>
                {{ $item->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Search by name..."
            id="keyword">
          <a for="" class="search-small-delete-icon" href="{{ route('admin.department.search') }}"><i
              class="bi bi-x-lg"></i></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="{{ route('admin.department.create') }}">
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width:50px">#</th>
          <th scope="col">Department name</th>
          <th scope="col">Facutly</th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $department)
          <tr style="cursor: pointer;" @hasPermission('department_edit')
            data-url="{{ route('admin.department.edit', ['id' => $department->id]) }}" @endhasPermission
            class="tb-row">
            <th scope="row">{{ $department->id }}</th>
            <td>{{ $department->name }}</td>
            <td>{{ $department->faculty->name }}</td>
            <td class="text-end">
              @hasPermission('department_delete')
                <a href="{{ route('admin.department.delete', ['id' => $department->id]) }}" class="action-delete invisible"
                  data-url="{{ route('admin.department.delete', ['id' => $department->id]) }}">
                  <button class="button-delete">
                    <i class="bi bi-trash3"></i>
                  </button>
                </a>
              @endhasPermission
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
    $('[name="faculty_id"]').change(function(e) {
      $('#search').submit();
    });
  </script>
@endsection
