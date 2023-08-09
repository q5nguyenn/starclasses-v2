@php
  $active = 'slider';
@endphp
@extends('admin.master')
@section('title')
  <title>Slider Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
  <style>
    .img-slider {
      width: 300px;
      height: 110px;
      object-fit: cover
    }
  </style>
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">SLIDER MANAGEMENT</div>
    </div>
    <a href="{{ route('admin.slider.create') }}" class="float-end">
      <button class="button-fa button-add">
        <i class="bi bi-file-earmark-plus"></i>
      </button>
    </a>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 50px">#</th>
          <th scope="col" style="width: 0px">Thumbnail</th>
          <th scope="col">Course</th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $slider)
          <tr data-parent-id="{{ $slider->id }}" style="cursor: pointer;"
            data-url="{{ route('admin.slider.edit', ['id' => $slider->id]) }}" class="tb-row">
            <th scope="row">{{ $slider->id }}</th>
            <td><img class="img-slider" src="{{ $slider->thumbnail }}" alt=""></td>
            <td>{{ $slider->course->name }}</td>
            <td class="text-end">
              {{-- <a href="{{ route('admin.slider.edit', ['id' => $slider->id]) }}">
						<button class="button-edit">
							<i class="bi bi-pencil"></i>
						</button>
					</a> --}}
              <a href="{{ route('admin.slider.delete', ['id' => $slider->id]) }}"
                data-url="{{ route('admin.slider.delete', ['id' => $slider->id]) }}" class="action-delete invisible">
                <button class="button-delete">
                  <i class="bi bi-trash3"></i>
                </button>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{-- {{ $list->links() }} --}}
  </div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/admin/index.js') }}"></script>
@endsection
