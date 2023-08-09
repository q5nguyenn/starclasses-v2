@php
  $active = 'notification';
@endphp
@extends('admin.master')
@section('title')
  <title>Notification Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">NOTIFICATION MANAGEMENT</div>
    </div>
    <div class="d-flex align-items-center">
      <div class="profile-cover-menu me-auto">
        <a class="profile-cover-menu-item is-active" href="{{ route('admin.notification.index') }}">
          <i class="bi bi-envelope-paper"></i>
          <span class="profile-cover-menu-item-content">Inbox</span>
        </a>
        <a class="profile-cover-menu-item" href="{{ route('admin.notification.sent') }}">
          <i class="bi bi-send"></i>
          <span class="profile-cover-menu-item-content">Sent</span>
        </a>
      </div>
      {{-- <div class="search-small-result">{{ $count }} kết quả</div> --}}
      <form class="search-small d-flex" autocomplete="off" action="{{ route('admin.notification.search') }}"
        id="search">
        <div class="input-item d-flex me-2">
          <select class="form-select text-secondary" aria-label="Default select example" name="sort_by">
            <option selected value="">Sort by</option>
            <option value="newest" {{ ($sort_by ?? '') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ ($sort_by ?? '') == 'oldest' ? 'selected' : '' }}>Oldest</option>
          </select>
        </div>
        <div class="input-item d-flex">
          <label for="keyword" class="search-small-icon" id="search-icon"><i class="bi bi-search"></i></label>
          <input type="text" class="input" name="keyword" value="{{ $keyword ?? '' }}"
            placeholder="Search by email, title, date..." style="width:360px" id="keyword">
          <a for="" class="search-small-delete-icon"
            href="{{ route('admin.notification.search', ['keyword' => '']) }}"><i class="bi bi-x-lg"></i></i></a>
          <span class="focus-input"></span>
        </div>
      </form>
      <a href="{{ route('admin.notification.create') }}">
        <button class="button-fa button-add">
          <i class="bi bi-pencil-square"></i> Compose
        </button>
      </a>
    </div>
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col" style="width: 50px">#</th>
          <th scope="col" style="width: 250px">From</th>
          {{-- <th scope="col" class="w-25">To</th> --}}
          <th scope="col">Title</th>
          <th scope="col" style="width:130px">Received date</th>
          <th scope="col" style="width:50px" class="text-center">Status</th>
          <th scope="col" class="text-center" style="width: 0px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list as $noti)
          <tr style="cursor: pointer;" data-url="{{ route('admin.notification.read', ['id' => $noti->inboxId]) }}"
            class="tb-row">
            <th scope="row">{{ $noti->inboxId }}</th>
            <td>{{ $noti->user->email }}</td>
            {{-- <td>
					@foreach ($noti->users as $index => $user)
					@if ($index != count($noti->users) - 1)
					<span>{{ $user->email }},</span>
					@else
					<span>{{ $user->email }}</span>
					@endif
					@endforeach
				</td> --}}
            <td class="fw-bold">{!! $noti->title !!}</td>
            <td>{{ $noti->created_at }}</td>
            <td class="text-center">{!! $noti->status == 0
                ? '<i class="bi bi-eye-slash text-danger"></i>'
                : '<i class="bi bi-eye text-success"></i>' !!}</td>
            <td class="text-end">
              {{-- <a href="{{ route('admin.notification.edit', ['id' => $noti->id]) }}">
						<button class="button-edit" >
							<i class="bi bi-pencil"></i>
						</button>
					</a> --}}
              <a href="{{ route('admin.notification.delete', ['id' => $noti->inboxId]) }}"
                class="action-delete invisible"
                data-url="{{ route('admin.notification.delete', ['id' => $noti->inboxId]) }}"
                data-status="{{ $noti->status }}">
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
  {{-- <script src="{{ asset('js/admin/index.js') }}"></script> --}}
  <script>
    $(document).ready(function() {
      $('.tb-row').click(function(e) {
        window.location = $(this).data('url');
      });

      $('.tb-row').mouseenter(function() {
        $(this).find('.action-delete').removeClass('invisible').addClass('visible');
      }).mouseleave(function() {
        $(this).find('.action-delete').removeClass('visible').addClass('invisible');
      });

      $('.action-delete').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        let urlRequest = $(this).data('url');
        let status = $(this).data('status');
        let that = $(this);
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "get",
              url: urlRequest,
              success: function(data) {
                that.parent().parent().fadeOut(500);
                if (status == 0) {
                  $('#cart-course').html(parseInt(parseInt($('#cart-course').html()) - 1));
                }
              }
            });
          }
        })
      });
      $('#search-icon').click(function(e) {
        $('#search').submit();
      });
      $('[name="sort_by"]').change(function(e) {
        $('#search').submit();
      });
    });
  </script>
@endsection
