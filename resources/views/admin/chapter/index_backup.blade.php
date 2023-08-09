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
    <div class="clearfix">
      <a href="{{ route('admin.chapter.create') }}" class="float-end">
        <button class="button-fa button-add">
          <i class="bi bi-file-earmark-plus"></i>
        </button>
      </a>
    </div>
    <label for="course_id">Choose a course</label>
    <div class="input-item" style="width:100%; padding-right: 8px">
      <select class="form-select js-example-placeholder2" aria-label="Default select example" name="course_id"
        id="course_id">
        <option value="">Choose a course</option>
        @foreach ($courses as $course)
          <option value="{{ $course->id }}">
            {{ $course->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="course-content" style="padding-right: 8px">
      <div class="course-content-title">Course content</div>
      <div class="course-content-info">
      </div>
      <div class="course-content-list">
      </div>
    </div>
    <!-- Video Popup -->
    <div class="video">
      <div class="video-container">
        <iframe width="956" height="538" src="#" title="lofi hip hop radio - beats to relax/study to"
          frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>
    </div>
    <div class="video-blur"></div>
    <!-- Search box hiển thị kết quả tìm kiếm -->
  </div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(".js-example-placeholder2").select2({
      placeholder: "Choose a course",
    })
    $('.js-example-placeholder2').change(function(e) {
      e.preventDefault();
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.form-select').change(function(e) {
        id = $(this).val();
        let urlRequest = "{{ route('admin.chapter.show') }}" + "?id=" + id;
        let htmlResult = '';
        let urlChapterEdit = "{{ route('admin.chapter.edit') }}";
        let urlChapterDlete = "{{ route('admin.chapter.delete') }}";
        $.ajax({
          type: "get",
          url: urlRequest,
          success: function(response) {
            let numberChapter = response.length;
            let timeTotal = numberChapter * 5;
            let hours = Math.floor(timeTotal / 60);
            let minutes = timeTotal % 60;
            response.forEach(item => {
              if (item['parent_id'] == 0) {
                numberChapter--;
                htmlResult += `<div class="course-content-item">
															<div class="course-content-item-title d-flex align-items-center chapter-parent tb-row"
															style="cursor: pointer;" data-url="${urlChapterEdit}?id=${item['id']}">
																<i class="bi bi-chevron-up"></i>
																<span class="me-auto">${item['content']}</span>
																<a href="${urlChapterDlete}?id=${item['id']}" class="action-delete invisible"
																data-url="${urlChapterDlete}?id=${item['id']}">
																	<button class="button-delete" >
																		<i class="bi bi-trash3"></i>
																	</button>
																</a>
															</div>
															<div class="course-content-wrapper course-content-show chapter-child">`;
                response.forEach(item2 => {
                  if (item2['parent_id'] == item['id']) {
                    htmlResult += `<div class="course-content-inner tb-row" style="cursor: pointer;" 
																											data-url="${urlChapterEdit}?id=${item2['id']}">
																											<i class="bi bi-file-earmark"></i>
																											<span class="count-content-name">${item2['content']}</span>
																											<span class="count-content-video"><a href="${item2['video_link']}">Video</a></span>
																											<span class="count-content-time">06:31</span>
																											<a href="${urlChapterDlete}?id=${item2['id']}" class="action-delete invisible"
																											data-url="${urlChapterDlete}?id=${item2['id']}">
																												<button class="button-delete-simple" >
																													<i class="bi bi-x-square"></i>
																												</button>
																											</a>
																										</div>`
                  }
                });
                htmlResult += `</div>`;
                htmlResult += `</div>`;
              }
            });
            $('.course-content-info').html(
              `<span class="course-number-section">${numberChapter} parts</span><i class="bi bi-dot"></i>
						<span class="course-time">Total time ${hours} hours ${minutes} minutes</span>`
            );
            $('.course-content-list').html(htmlResult);
          }
        });
      });
    });
  </script>
  <script>
    $("body").on("click", ".action-delete", function(e) {
      e.preventDefault();
      e.stopPropagation();
      that = $(this);
      let urlRequest = $(this).data('url');
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
              if (data.code == 200) {
                if (that.parent().hasClass('chapter-parent')) {
                  that.parent().parent().fadeOut(500);
                } else {
                  that.parent().fadeOut(500);
                }
              }
            }
          });
        }
      })
    });

    $("body").on("mouseenter mouseleave", ".tb-row", function(e) {
      var $this = $(e.currentTarget);
      $this.find('.action-delete').toggleClass('invisible');
    });

    $("body").on("click", ".tb-row", function(e) {
      window.location = $(this).data('url');
    });
  </script>
  <script src="{{ asset('js/admin/coursedesc.js') }}"></script>
@endsection
