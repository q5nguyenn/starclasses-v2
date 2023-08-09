@php
  $active = 'chapter';
@endphp
@extends('admin.master')
@section('title')
  <title>Chapter Management</title>
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/customSweetalert2.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin/coursedesc.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/customSelect2.css') }}" />
@endsection
@section('content')
  <div class="search-result">
    <div class="profile-frame-top my-3">
      <div class="profile-frame-title">CHAPTER MANAGEMENT</div>
    </div>
    @if ($all)
      <label for="course_id">Choose a course</label>
      <div class="input-item" style="width:100%; padding-right: 8px">
        <form action="{{ route('admin.chapter.index') }}" id="form-choose-course">
          <select class="form-select js-example-placeholder2" aria-label="Default select example" name="course_id"
            id="course_id">
            <option value="">Choose a course</option>
            @foreach ($courses as $course)
              <option value="{{ $course->id }}">
                {{ $course->name }}
              </option>
            @endforeach
          </select>
        </form>
      </div>
    @else
      <div for="course_id">Course</div>
      <div class="border p-2 bg-light">{{ $course->name }}</div>
      <div class="course-content" style="padding-right: 8px">
        <div class="course-content-title">Course content</div>
        <div class="course-content-info d-flex align-items-center">
          <span class="course-number-section">{{ $course->allChapters() }} parts</span><i class="bi bi-dot"></i>
          <span class="course-time me-auto">Total time 9 hours 9 minutes</span>
          <button class="button-delete" id="add-parent-chapter" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
            data-chapter="0">
            <a href="#" style="color: #00cf93">
              <i class="bi bi-file-earmark-plus"></i>
            </a>
          </button>
        </div>
        <div class="course-content-list">
          @foreach ($chapters as $chapter)
            @if ($chapter->parent_id == 0)
              <div class="course-content-item">
                <a class="course-content-item-title d-flex align-items-center chapter-parent tb-row"
                  style="cursor: pointer;" data-url="{{ route('admin.chapter.edit', ['id' => $chapter->id]) }}"
                  data-bs-toggle="modal" data-bs-target="#staticBackdrop" parent="true">
                  <i class="bi bi-chevron-up"></i>
                  <span class="me-auto">{{ $chapter->content }}</span>
                  <span class="action-delete invisible">
                    <button class="button-delete btn-add-chapter-child" style="color: #00cf93"
                      data-chapter="{{ $chapter->id }}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      <i class="bi bi-file-earmark-plus"></i>
                    </button>
                    <button class="button-delete btn-delete-chapter"
                      data-url="{{ route('admin.chapter.edit', ['id' => $chapter->id]) }}">
                      <i class="bi bi-trash3"></i>
                    </button>
                  </span>
                </a>
              </div>
              <div class="course-content-wrapper course-content-show chapter-child">
                @foreach ($chapters as $item)
                  @if ($item->parent_id == $chapter->id)
                    <div class="course-content-inner tb-row" style="cursor: pointer;"
                      data-url="{{ route('admin.chapter.edit', ['id' => $item->id]) }}" data-bs-toggle="modal"
                      data-bs-target="#staticBackdrop" parent="false">
                      <i class="bi bi-file-earmark"></i>
                      <span class="count-content-name">{{ $item->content }}</span>
                      <span class="count-content-video"><a href="{{ $item->video_link }}"
                          data-bs-dismiss="modal">Video</a></span>
                      <span class="count-content-time">06:31</span>
                      <a href="#" class="action-delete invisible">
                        <button class="button-delete-simple btn-delete-chapter"
                          data-url="{{ route('admin.chapter.edit', ['id' => $item->id]) }}">
                          <i class="bi bi-x-square"></i>
                        </button>
                      </a>
                    </div>
                  @endif
                @endforeach
              </div>
            @endif
          @endforeach
        </div>
    @endif


    <!-- Video Popup -->
    <div class="video" style="display:none">
      <div class="video-container">
        <iframe width="956" height="538" src="" title="lofi hip hop radio - beats to relax/study to"
          frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>
    </div>
    <div class="video-blur" style="display:none"></div>
    <!-- Search box hiển thị kết quả tìm kiếm -->
  </div>
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-lg" style="width: 800px">
      <div class="modal-content">
        <div class="m-3 text-center text-uppercase fw-bold">
          <h5 class="modal-title" id="staticBackdropLabel">Add chapter</h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.chapter.store') }}" method="post" id="form-action-chapter"
            onsubmit="saveScrollPosition()">
            @csrf
            <label for="content" hidden>Hidden Info</label>
            <div class="input-item" hidden>
              <input type="text" value="{{ $course->id }}" name="course_id" id="course_id2">
              <input type="text" value="0" name="parent_id" id="parent_id">
              <input type="text" value="0" name="id" id="id">
            </div>
            <label for="content">Chapter name</label>
            <div class="input-item">
              <input type="text" class="input" id="content" name="content">
              <span class="focus-input"></span>
            </div>
            <div class="input-item-error">&nbsp;
            </div>
            <label for="video_link" class="all_video_link" style="display:none">Video link</label>
            <div class="input-item all_video_link" style="display:none">
              <input type="text" class="input" id="video_link" name="video_link" value="">
              <span class="focus-input"></span>
              <div class="button-play-preview"><i class="bi bi-play"></i></div>
            </div>
            <div class="input-item-error">&nbsp;
            </div>
          </form>
        </div>
        <div class="m-3 text-end">
          <button type="button" class="btn-save mx-2" id="btn-action-chapter">Save</button>
          <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade" style="display:none"></div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
  <script src="{{ asset('js/admin/utilities.js') }}"></script>
  <script>
    $(".js-example-placeholder2").select2({
      placeholder: "Choose a course",
    })

    $('.js-example-placeholder2').change(function(e) {
      e.preventDefault();
    });

    $('#course_id').change(function(e) {
      e.preventDefault();
      $('#form-choose-course').submit();
    });

    let course_id = '{{ $course->id }}';
    let routeStore = '{{ route('admin.chapter.store') }}';
    let routeUpdate = '{{ route('admin.chapter.update') }}';
    let routeDelete = '{{ route('admin.chapter.delete') }}';

    $(".btn-add-chapter-child").click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      $('.all_video_link').show();
      $("#form-action-chapter").attr("action", routeStore);
      $('.modal-title').html("Add chapter");
      $('#btn-action-chapter').html('Save');
      clearInput();
      showModal();
      let chapter = $(this).data('chapter');
      $('#parent_id').val(chapter);
    });

    $("#add-parent-chapter").click(function(e) {
      $('.all_video_link').hide();
      $('.modal-title').html("Add parent chapter");
      $("#form-action-chapter").attr("action", routeStore);
      $('#btn-action-chapter').html('Save');
      clearInput();
      showModal();
    });

    $(".btn-delete-chapter").click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      $('.all_video_link').hide();
      $('#btn-action-chapter').html('Delete');
      $('.modal-title').html("Delete chapter");
      $("#form-action-chapter").attr("action", routeDelete);
      clearInput();
      let urlRequest = $(this).data('url');
      $.ajax({
        type: "get",
        url: urlRequest,
        success: function(response) {
          $('#course_id2').val(response['course_id']);
          $('#parent_id').val(response['parent_id']);
          $('#content').val(response['content']);
          $('#video_link').val(response['video_link']);
          $('#id').val(response['id']);
          showModal();
        }
      });
    });

    $("body").on("mouseenter mouseleave", ".tb-row", function(e) {
      var $this = $(e.currentTarget);
      $this.find('.action-delete').toggleClass('invisible');
    });

    $("body").on("click", ".tb-row", function(e) {
      e.preventDefault();
      let parent = $(this).attr('parent');
      if (parent == 'true') {
        $('.all_video_link').hide();
      } else {
        $('.all_video_link').show();
      }
      $("#form-action-chapter").attr("action", routeUpdate);
      $('.modal-title').html("Update chapter");
      $('#btn-action-chapter').html('Save');
      let urlRequest = $(this).data('url');
      $.ajax({
        type: "get",
        url: urlRequest,
        success: function(response) {
          $('#course_id2').val(response['course_id']);
          $('#parent_id').val(response['parent_id']);
          $('#content').val(response['content']);
          $('#video_link').val(response['video_link']);
          $('#id').val(response['id']);
          showModal();
        }
      });
    });

    $("body").on("click", "#btn-action-chapter", function(e) {
      e.preventDefault();
      $('#form-action-chapter').submit();
    });

    function clearInput() {
      $('#course_id2').val(course_id);
      $('#parent_id').val(0);
      $('#content').val('');
      $('#video_link').val('');

    }

    $('.count-content-video a').click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      let video_link = $(this).attr('href');
      $('iframe').attr('src', video_link);
      $('.video').show();
      $('.video-blur').show();
    });
    $('.video-blur').click(function(e) {
      e.preventDefault();
      $('.video').hide();
      $('.video-blur').hide();
    });

    // Lưu giá trị scroll hiện tại vào localStorage
    function saveScrollPosition() {
      localStorage.setItem('scrollPosition', window.scrollY);
    }

    // Khôi phục giá trị scroll sau khi chuyển hướng trở lại trang
    function restoreScrollPosition() {
      var scrollPosition = localStorage.getItem('scrollPosition');
      if (scrollPosition !== null) {
        window.scrollTo(0, scrollPosition);
        localStorage.removeItem('scrollPosition'); // Xóa giá trị đã lưu sau khi khôi phục
      }
    }

    // Khôi phục giá trị scroll sau khi trang được tải lại
    document.addEventListener('DOMContentLoaded', function() {
      @if (session('scrollPosition'))
        {{ session('scrollPosition') }}
      @endif
    });

    $('.btn-cancel').click(function(e) {
      e.preventDefault();
      hideModel();
    });

    $('.modal').click(function(e) {
      e.preventDefault();
      if (!$(event.target).closest('.modal-content').length) {
        hideModel();
      }
    });

    function showModal() {
      $('.modal-backdrop').addClass('show');
      $('.modal-backdrop').show();
      $('#staticBackdrop').addClass('show');
      $('#staticBackdrop').show();
      $('#content').focus();
    }

    function hideModel() {
      $('.modal-backdrop').hide();
      $('#staticBackdrop').removeClass('show');
      $('#staticBackdrop').hide();
    }
  </script>
@endsection
