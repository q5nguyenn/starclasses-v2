@php
  $active = 'report';
@endphp
@extends('admin.master')
@section('title')
  <title>Report Management</title>
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
      <div class="profile-frame-title">REPORT MANAGEMENT</div>
    </div>
    <div class="float-end d-flex align-items-center">
      {{-- <div class="search-small-result">{{ $count }} kết quả</div> --}}
      <form class="search-small d-flex" autocomplete="off" action="{{ route('admin.report.search') }}" id="search">
        <div class="input-item d-flex me-2">
          <select class="form-select text-secondary" aria-label="Default select example" name="status">
            <option selected value="">Choose a status</option>
            <option value="uncheck" {{ ($status ?? '') == 'uncheck' ? 'selected' : '' }}>Uncheck</option>
            <option value="fixing" {{ ($status ?? '') == 'fixing' ? 'selected' : '' }}>Fixing</option>
            <option value="fixed" {{ ($status ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
          </select>
        </div>
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}" style="width:360px"
            placeholder="Search by type..." id="keyword">
          <a for="" class="search-small-delete-icon" href="{{ route('admin.report.search') }}"><i
              class="bi bi-x-lg"></i></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="#" class="float-end" disabled>
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>

    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 50px">#</th>
          <th scope="col" style="width: 0px">Thumbnail</th>
          <th scope="col">Description</th>
          <th scope="col" style="width: 200px">Type</th>
          <th scope="col" style="width: 150px">Status</th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $report)
          <tr data-parent-id="{{ $report->id }}" style="cursor: pointer;" data-url="#" class="tb-row">
            <th scope="row">{{ $report->id }}</th>
            <td>
              <div class="d-flex">
                @foreach ($report->reportImages as $image)
                  <div class="img-thumbnail img-report"><img class="img-fluid" src="{{ $image->thumbnail }}"
                      alt=""></div>
                @endforeach
              </div>
            </td>
            <td>{{ $report->description }}</td>
            <td>{{ $report->type }}</td>
            <td>
              <select class="form-select text-secondary update_status_report"
                data-url="{{ route('admin.report.update', ['id' => $report->id]) }}">
                <option value="uncheck" {{ $report->status == 'uncheck' ? 'selected' : '' }}>Uncheck</option>
                <option value="fixing" {{ $report->status == 'fixing' ? 'selected' : '' }}>Fixing</option>
                <option value="fixed" {{ $report->status == 'fixed' ? 'selected' : '' }}>Fixed</option>
              </select>
            </td>
            <td class="text-end">
              <a href="#" data-url="{{ route('admin.report.delete', ['id' => $report->id]) }}"
                class="action-delete invisible">
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
  <script>
    $('.img-report').click(function(e) {
      e.preventDefault();
      let img = $(this).find('img').attr('src');
      Swal.fire({
        imageUrl: img,
        imageAlt: 'A tall image',
        customClass: {
          popup: 'custom-popup',
          image: 'custom-image'
        }
      })
    });
    $('.update_status_report').change(function(e) {
      e.preventDefault();
      let urlRequest = $(this).data('url');
      let val = $(this).val();
      let data = {
        val: val
      };
      $.ajax({
        type: "get",
        url: urlRequest,
        data: data,
        success: function(response) {

        }
      });

    });
  </script>
  <script>
    $('[name="status"]').change(function(e) {
      $('#search').submit();
    });
  </script>
@endsection
