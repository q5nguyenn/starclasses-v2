@php
  $active = 'role';
@endphp
@extends('admin.master')
@section('title')
  <title>Role Management</title>
@endsection
@section('css')
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">UPDATE ROLE</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame-flex profile-frame-width" id="active-voucher" novalidate method="post"
          action="{{ route('admin.role.update', ['id' => $role->id]) }}">
          @csrf
          <label for="name">Role name</label>
          <div class="input-item">
            <input type="text" class="input" id="name" name="name" value="{{ old('name', $role->name) }}" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('name')
              {{ $message }}
            @enderror
          </div>
          <label for="description">Description</label>
          <div class="input-item">
            <input type="text" class="input" id="description" name="description"
              value="{{ old('description', $role->description) }}" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('description')
              {{ $message }}
            @enderror
          </div>
          {{-- <div class="input-item">
					<select class="form-control js-example-tokenizer" multiple="multiple" name="roles[]">
						<option value=""></option>
						@foreach ($roles as $role)
								<option value="{{ $role->id }}">{{ $role->name }}</option>
						@endforeach
					</select>
				</div> --}}
          <div class="card mb-4">
            <div class="card-header">
              <div class="form-check">
                <input class="form-check-input checkbox_parent_all" type="checkbox" id="checkboxAll">
                <label class="form-check-label" for="checkboxAll">Check all</label>
              </div>
            </div>
          </div>
          @foreach ($list as $permission)
            <div class="card mb-4">
              <div class="card-header">
                <div class="form-check">
                  <input class="form-check-input checkbox_parent" type="checkbox" id="checkbox{{ $permission->id }}">
                  <label class="form-check-label" for="checkbox{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  @foreach ($permission->permissionChilds as $permission_child)
                    <div class="form-check form-check-inline col-3 me-0 ps-5">
                      <input class="form-check-input checkbox_child" type="checkbox"
                        id="checkbox{{ $permission_child->id }}" value="{{ $permission_child->id }}" name="permissions[]"
                        {{ $role_permissions->contains('id', $permission_child->id) ? 'checked' : '' }}>
                      <label class="form-check-label"
                        for="checkbox{{ $permission_child->id }}">{{ $permission_child->name }}</label>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          @endforeach
          <button class="button-fa button-active-voucher-mobile" type="submit">
            Update
          </button>
        </form>
        <div class="profile-frame-wrapper-title voucher-content"></div>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.checkbox_parent').click(function() {
        $(this).parents('.card').find('.checkbox_child').prop('checked', $(this).prop('checked'));
      })
      $('.checkbox_parent_all').click(function() {
        $(this).parents('').find('.checkbox_child').prop('checked', $(this).prop('checked'));
      })
    });
  </script>
@endsection
