@php
  $active = 'role';
@endphp
@extends('admin.master')
@section('title')
  <title>Role Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">ROLE MANAGEMENT</div>
    </div>
    <a href="{{ route('admin.role.create') }}" class="float-end">
      <button class="button-fa button-add">
        <i class="bi bi-file-earmark-plus"></i>
      </button>
    </a>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 50px">#</th>
          <th scope="col" style="width: 200px">Role name</th>
          <th scope="col">Description</th>
          <th scope="col" style="width: 0px"></th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $role)
          <tr class="normal {{ $role->name == 'Admin' ? 'super-admin' : '' }} tb-row" style="cursor: pointer;"
            data-url="{{ route('admin.role.edit', ['id' => $role->id]) }}">
            <th scope="row">{{ $role->id }}</th>
            <td>{{ $role->name }}</td>
            <td>{{ $role->description }}</td>
            <td><img src="{{ asset('goku.png') }}" alt=""></td>
            <td class="text-end">
              {{-- <a href="{{ route('admin.role.edit', ['id' => $role->id]) }}">
						<button class="button-edit" >
							<i class="bi bi-pencil"></i>
						</button>
					</a> --}}
              <a href="{{ route('admin.role.delete', ['id' => $role->id]) }}" class="action-delete invisible"
                data-url="{{ route('admin.role.delete', ['id' => $role->id]) }}">
                <button class="button-delete" ">
                         <i class="bi bi-trash3"></i>
                        </button>
                       </a>
                      </td>
                     </tr>
   @endforeach
      </tbody>
    </table>
    {{ $list->links() }}
  </div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/admin/index.js') }}"></script>
@endsection
