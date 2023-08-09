@php
  $active = 'department';
@endphp
@extends('admin.master')
@section('title')
  <title>Department Management</title>
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame" data-frame="2">
      <div class="profile-frame-top my-3">
        <div class="profile-frame-title">UPDATE DEPARTMENT</div>
      </div>
      <div class="profile-frame-wrapper">
        <form class="profile-frame-flex profile-frame-width" id="active-voucher" novalidate method="post"
          action="{{ route('admin.department.update', ['id' => $department->id]) }}">
          @csrf
          <label for="name">Department name</label>
          <div class="input-item">
            <input type="text" class="input" id="name" name="name"
              value="{{ old('name', $department->name) }}" />
            <span class="focus-input"></span>
          </div>
          <div class="input-item-error">&nbsp;
            @error('name')
              {{ $message }}
            @enderror
          </div>
          <label for="faculty_id">Faculty</label>
          <select class="form-select text-secondary" aria-label="Default select example" name="faculty_id"
            id="faculty_id">
            <option value="">Chọn khoa</option>
            @foreach ($listFaculties as $item)
              <option value="{{ $item->id }}" @if ($item->id == old('faculty_id', $department->faculty_id)) {{ 'selected' }} @endif>
                {{ $item->name }}</option>
            @endforeach
          </select>
          <div class="input-item-error">&nbsp;
            @error('faculty_id')
              {{ $message }}
            @enderror
          </div>
          <button class="button-fa button-active-voucher-mobile" type="submit" style="margin-top: 25px">
            Update
          </button>
        </form>
        <div class="profile-frame-wrapper-title voucher-content"></div>
      </div>
    </div>
  </div>
@endsection
