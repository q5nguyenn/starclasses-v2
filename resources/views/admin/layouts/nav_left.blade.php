<div class="search-filter" style="margin-top:1rem">
  <!-- item 1 -->
  <a class="search-filter-title {{ $active == 'index' ? 'is-active' : '' }}" href="{{ route('admin.index') }}">
    <i class="bi bi-star"></i> <span>Home</span>
  </a>
  <!-- item 2 -->
  @hasPermission('faculty_list')
    <a class="search-filter-title {{ $active == 'faculty' ? 'is-active' : '' }}" href="{{ route('admin.faculty.index') }}">
      <i class="bi bi-bank"></i> <span>Faculties</span>
    </a>
  @endhasPermission
  <!-- item 3 -->
  @hasPermission('department_list')
    <a class="search-filter-title {{ $active == 'department' ? 'is-active' : '' }}"
      href="{{ route('admin.department.index') }}">
      <i class="bi bi-bank2"></i> <span>Departments</span>
    </a>
  @endhasPermission
  <!-- item 4 -->
  @hasPermission('course_list')
    <a class="search-filter-title {{ $active == 'course' ? 'is-active' : '' }}" href="{{ route('admin.course.index') }}">
      <i class="bi bi-book"></i> <span>Courses</span>
    </a>
  @endhasPermission
  <!-- item 5 -->
  @hasPermission('chapter_list')
    <a class="search-filter-title {{ $active == 'chapter' ? 'is-active' : '' }}"
      href="{{ route('admin.chapter.index') }}">
      <i class="bi bi-journal-bookmark-fill"></i> <span>Chapters</span>
    </a>
  @endhasPermission
  <hr>
  <!-- item 6 -->
  @hasPermission('user_list')
    <a class="search-filter-title {{ $active == 'user' ? 'is-active' : '' }}" href="{{ route('admin.user.index') }}">
      <i class="bi bi-person-lines-fill"></i> <span>Users</span>
    </a>
  @endhasPermission
  <!-- item 7 -->
  @hasPermission('bill_list')
    <a class="search-filter-title {{ $active == 'bill' ? 'is-active' : '' }}" href="{{ route('admin.bill.index') }}">
      <i class="bi bi-bag-check"></i> <span>Bills</span>
    </a>
  @endhasPermission
  <!-- item 8 -->
  @hasPermission('review_list')
    <a class="search-filter-title {{ $active == 'review' ? 'is-active' : '' }}"
      href="{{ route('admin.review.index') }}">
      <i class="bi bi-hand-thumbs-up"></i> <span>Reviews</span>
    </a>
  @endhasPermission
  <!-- item 9 -->
  @hasPermission('slider_list')
    <a class="search-filter-title {{ $active == 'slider' ? 'is-active' : '' }}"
      href="{{ route('admin.slider.index') }}">
      <i class="bi bi-images"></i> <span>Sliders</span>
    </a>
    <hr>
  @endhasPermission
  <!-- item 10 -->
  @hasPermission('code_list')
    <a class="search-filter-title  {{ $active == 'code' ? 'is-active' : '' }}" href="{{ route('admin.code.index') }}">
      <i class="bi bi-ticket-perforated"></i> <span>Code</span>
    </a>
  @endhasPermission
  <!-- item 11 -->
  @hasPermission('combo_list')
    <a class="search-filter-title  {{ $active == 'combo' ? 'is-active' : '' }}" href="{{ route('admin.combo.index') }}">
      <i class="bi bi-ticket-perforated"></i> <span>Combo</span>
    </a>
  @endhasPermission
  <!-- item 12 -->
  @hasPermission('notification_list')
    <a class="search-filter-title  {{ $active == 'notification' ? 'is-active' : '' }}"
      href="{{ route('admin.notification.index') }}">
      <i class="bi bi-bell"></i> <span>Notifications</span>
    </a>
  @endhasPermission
  <!-- item 13 -->
  @hasPermission('role_list')
    <a class="search-filter-title  {{ $active == 'role' ? 'is-active' : '' }}" href="{{ route('admin.role.index') }}">
      <i class="bi bi-shield-check"></i> <span>Roles</span>
    </a>
  @endhasPermission
  <hr>
  <!-- item 14 -->
  @hasPermission('report_list')
    <a class="search-filter-title  {{ $active == 'report' ? 'is-active' : '' }}"
      href="{{ route('admin.report.index') }}">
      <i class="bi bi-bug"></i> <span>Reports</span>
    </a>
  @endhasPermission
</div>
