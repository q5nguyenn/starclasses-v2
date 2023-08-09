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
    <div class="fw-bold text-uppercase fs-4 p-3 d-flex" style="padding-left:55px !important" style="cursor: pointer;">
      <div class="me-auto">{{ $notification->title }}</div>
      <a href="#" class="action-delete"
        data-url="{{ route('admin.notification.delete', ['id' => $notification_user->id]) }}">
        <button class="button-delete">
          <i class="bi bi-trash3"></i>
        </button>
      </a>
    </div>
    <div class="d-flex">
      <div class="nav-user-img p-0"><img src="{{ env('BASE_URL') . $notification->user->thumbnail }}" alt="">
      </div>
      <div class="ps-3 w-100" style="padding-right: 8px">
        <div class="d-flex">
          <div class="me-auto">
            <span>{{ $notification->user->name }}</span>
            <small class="text-secondary">&#60;{{ $notification->user->email }}&#62;</small>
          </div>
          <small class="text-secondary">{{ $notification->created_at }}</small>
        </div>
        <small class="text-secondary">
          to
          <span>
            @foreach ($notification->users as $index => $user)
              @if ($index != count($notification->users) - 1)
                <span>{{ $user->email }},</span>
              @else
                <span>{{ $user->email }}</span>
              @endif
            @endforeach
          </span>
        </small>
        <div>
          {!! $notification->content !!}
        </div>
        <div>
          <a href="{{ route('admin.notification.create', ['to' => $notification->user_id]) }}">
            <button class="button-fa" type="submit">
              <i class="bi bi-reply"></i>Reply
            </button>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div>
  </div>
  </div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $('.action-delete').click(function(e) {
      e.preventDefault();
      let urlRequest = $(this).data('url');
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
              window.open("{{ route('admin.notification.index') }}");
            }
          });
        }
      })
    });
  </script>
@endsection
