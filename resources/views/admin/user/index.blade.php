@php
  $active = 'user';
@endphp
@extends('admin.master')
@section('title')
  <title>User management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">USER MANAGEMENT</div>
    </div>
    <div class="d-flex align-items-center justify-content-end">
      {{-- <div class="search-small-result">{{ $count }} kết quả</div> --}}
      <form class="search-small d-flex" autocomplete="off" action="{{ route('admin.user.search') }}" id="search">
        <div class="input-item d-flex me-2">
          <select class="form-select text-secondary" aria-label="Default select example" name="role_id">
            <option selected value="">Choose a role</option>
            @foreach ($roles as $item)
              <option value="{{ $item->id }}" {{ $item->id == ($role_id ?? 0) ? 'selected' : '' }}>{{ $item->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}"
            placeholder="Search by name, email, phone number..." style="width:360px" id="keyword">
          <a for="" class="search-small-delete-icon" href="{{ route('admin.user.search') }}"><i
              class="bi bi-x-lg"></i></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="{{ route('admin.user.create') }}">
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 50px">#</th>
          <th scope="col">User name</th>
          <th scope="col">Date created</th>
          <th scope="col">Email</th>
          <th scope="col">Phone number</th>
          <th scope="col" style="width: 0px">Role</th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $user)
          <tr style="cursor: pointer;" data-url="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="tb-row">
            <th scope="row">{{ $user->id }}</th>
            <td>
              <div class="row">
                <div class="nav-user-img p-0"><img src="{{ $user->thumbnail }}" alt=""></div>
                <div class="col fw-bold w-100">{{ $user->name }}</div>
              </div>
            </td>
            <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone_number }}</td>
            <td>
              @foreach ($user->roles as $role)
                {{ $role->name }}
              @endforeach
            </td>
            <td class="text-end">
              <a href="{{ route('admin.user.delete', ['id' => $user->id]) }}" class="action-delete invisible"
                data-url="{{ route('admin.user.delete', ['id' => $user->id]) }}">
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
    $('[name="role_id"]').change(function(e) {
      e.preventDefault();
      $('#search').submit();
    });
  </script>
@endsection
