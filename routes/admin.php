<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminBillController;
use App\Http\Controllers\admin\AdminChapterController;
use App\Http\Controllers\admin\AdminCodeController;
use App\Http\Controllers\admin\AdminComboController;
use App\Http\Controllers\admin\AdminCourseController;
use App\Http\Controllers\admin\AdminDataController;
use App\Http\Controllers\admin\AdminDepartmentController;
use App\Http\Controllers\admin\AdminFacultyController;
use App\Http\Controllers\admin\AdminNotificationController;
use App\Http\Controllers\admin\AdminReportController;
use App\Http\Controllers\admin\AdminReviewController;
use App\Http\Controllers\admin\AdminRoleController;
use App\Http\Controllers\admin\AdminSearchController;
use App\Http\Controllers\admin\AdminSliderController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\ChatAppController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Main route --> start
// Route::get('/', function () {
// 	return view('welcome');
// });

Route::get('/', [AdminController::class, 'index'])->name('admin.index');

Route::prefix('chat-app')->group(function () {
	Route::get('/', [ChatAppController::class, 'index'])->name('chatapp.index')->middleware('check_permisson:chat_home');
	Route::get('/send', [ChatAppController::class, 'send'])->name('chatapp.send')->middleware('check_permisson:chat_send');
	Route::get('/get', [ChatAppController::class, 'get'])->name('chatapp.get')->middleware('check_permisson:chat_get');
});


Route::prefix('faculty')->group(function () {
	Route::get('/', [AdminFacultyController::class, 'index'])->name('admin.faculty.index')->middleware('check_permisson:faculty_list');
	Route::get('/create', [AdminFacultyController::class, 'create'])->name('admin.faculty.create')->middleware('check_permisson:faculty_create');
	Route::post('/store', [AdminFacultyController::class, 'store'])->name('admin.faculty.store')->middleware('check_permisson:faculty_create');
	Route::get('/edit', [AdminFacultyController::class, 'edit'])->name('admin.faculty.edit')->middleware('check_permisson:faculty_edit');
	Route::post('/update', [AdminFacultyController::class, 'update'])->name('admin.faculty.update')->middleware('check_permisson:faculty_edit');
	Route::get('/delete', [AdminFacultyController::class, 'delete'])->name('admin.faculty.delete')->middleware('check_permisson:faculty_delete');
	// Route::get('/restore', [AdminFacultyController::class, 'restore'])->name('admin.faculty.restore');
	Route::get('/search', [AdminFacultyController::class, 'search'])->name('admin.faculty.search')->middleware('check_permisson:faculty_list');
});

Route::prefix('department')->group(function () {
	Route::get('/', [AdminDepartmentController::class, 'index'])->name('admin.department.index')->middleware('check_permisson:department_list');
	Route::get('/create', [AdminDepartmentController::class, 'create'])->name('admin.department.create')->middleware('check_permisson:department_create');
	Route::post('/store', [AdminDepartmentController::class, 'store'])->name('admin.department.store')->middleware('check_permisson:department_create');
	Route::get('/edit', [AdminDepartmentController::class, 'edit'])->name('admin.department.edit')->middleware('check_permisson:department_edit');
	Route::post('/update', [AdminDepartmentController::class, 'update'])->name('admin.department.update')->middleware('check_permisson:department_edit');
	Route::get('/delete', [AdminDepartmentController::class, 'delete'])->name('admin.department.delete')->middleware('check_permisson:department_delete');
	Route::get('/search', [AdminDepartmentController::class, 'search'])->name('admin.department.search')->middleware('check_permisson:department_list');
});

Route::prefix('signin')->group(function () {
	Route::get('/', [AdminController::class, 'login'])->name('admin.login');
	Route::post('/submit', [AdminController::class, 'postLogin'])->name('admin.signin');
});

Route::prefix('signout')->group(function () {
	Route::get('/', [AdminController::class, 'signout'])->name('admin.signout');
});

Route::prefix('course')->group(function () {
	Route::get('/', [AdminCourseController::class, 'index'])->name('admin.course.index')->middleware('check_permisson:course_list');
	Route::get('/create', [AdminCourseController::class, 'create'])->name('admin.course.create')->middleware('check_permisson:course_create');
	Route::post('/store', [AdminCourseController::class, 'store'])->name('admin.course.store')->middleware('check_permisson:course_create');
	Route::get('/edit', [AdminCourseController::class, 'edit'])->name('admin.course.edit')->middleware(['check_permisson:course_edit', 'check_course_author']);
	Route::post('/update', [AdminCourseController::class, 'update'])->name('admin.course.update')->middleware(['check_permisson:course_edit', 'check_course_author']);
	Route::get('/delete', [AdminCourseController::class, 'delete'])->name('admin.course.delete')->middleware(['check_permisson:course_delete', 'check_course_author']);
	Route::get('/search', [AdminCourseController::class, 'search'])->name('admin.course.search')->middleware('check_permisson:course_list');
});

Route::prefix('user')->group(function () {
	Route::get('/', [AdminUserController::class, 'index'])->name('admin.user.index')->middleware('check_permisson:user_list');
	Route::get('/create', [AdminUserController::class, 'create'])->name('admin.user.create')->middleware('check_permisson:user_create');
	Route::post('/store', [AdminUserController::class, 'store'])->name('admin.user.store')->middleware('check_permisson:user_create');
	Route::get('/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit')->middleware('check_permisson:user_edit');
	Route::post('/update', [AdminUserController::class, 'update'])->name('admin.user.update')->middleware('check_permisson:user_edit');
	Route::get('/delete', [AdminUserController::class, 'delete'])->name('admin.user.delete')->middleware('check_permisson:user_delete');
	Route::get('/search', [AdminUserController::class, 'search'])->name('admin.user.search')->middleware('check_permisson:user_list');
});

Route::prefix('role')->group(function () {
	Route::get('/', [AdminRoleController::class, 'index'])->name('admin.role.index')->middleware('check_permisson:role_list');
	Route::get('/create', [AdminRoleController::class, 'create'])->name('admin.role.create')->middleware('check_permisson:role_create');
	Route::post('/store', [AdminRoleController::class, 'store'])->name('admin.role.store')->middleware('check_permisson:role_create');
	Route::get('/edit', [AdminRoleController::class, 'edit'])->name('admin.role.edit')->middleware('check_permisson:role_edit');
	Route::post('/update', [AdminRoleController::class, 'update'])->name('admin.role.update')->middleware('check_permisson:role_edit');
	Route::get('/delete', [AdminRoleController::class, 'delete'])->name('admin.role.delete')->middleware('check_permisson:role_delete');
});

Route::prefix('slider')->group(function () {
	Route::get('/', [AdminSliderController::class, 'index'])->name('admin.slider.index')->middleware('check_permisson:slider_list');
	Route::get('/create', [AdminSliderController::class, 'create'])->name('admin.slider.create')->middleware('check_permisson:slider_create');
	Route::post('/store', [AdminSliderController::class, 'store'])->name('admin.slider.store')->middleware('check_permisson:slider_create');
	Route::get('/edit', [AdminSliderController::class, 'edit'])->name('admin.slider.edit')->middleware('check_permisson:slider_edit');
	Route::post('/update', [AdminSliderController::class, 'update'])->name('admin.slider.update')->middleware('check_permisson:slider_edit');
	Route::get('/delete', [AdminSliderController::class, 'delete'])->name('admin.slider.delete')->middleware('check_permisson:slider_delete');
});

Route::prefix('bill')->group(function () {
	Route::get('/', [AdminBillController::class, 'index'])->name('admin.bill.index')->middleware('check_permisson:bill_list');
	Route::get('/create', [AdminBillController::class, 'create'])->name('admin.bill.create')->middleware('check_permisson:bill_create');
	Route::post('/store', [AdminBillController::class, 'store'])->name('admin.bill.store')->middleware('check_permisson:bill_create');
	Route::get('/edit', [AdminBillController::class, 'edit'])->name('admin.bill.edit')->middleware('check_permisson:bill_edit');
	Route::post('/update', [AdminBillController::class, 'update'])->name('admin.bill.update')->middleware('check_permisson:bill_edit');
	Route::get('/delete', [AdminBillController::class, 'delete'])->name('admin.bill.delete')->middleware('check_permisson:bill_delete');
	Route::get('/search', [AdminBillController::class, 'search'])->name('admin.bill.search')->middleware('check_permisson:bill_list');
});

Route::prefix('review')->group(function () {
	Route::get('/', [AdminReviewController::class, 'index'])->name('admin.review.index')->middleware('check_permisson:review_list');
	Route::get('/create', [AdminReviewController::class, 'create'])->name('admin.review.create')->middleware('check_permisson:review_create');
	Route::post('/store', [AdminReviewController::class, 'store'])->name('admin.review.store')->middleware('check_permisson:review_create');
	Route::get('/edit', [AdminReviewController::class, 'edit'])->name('admin.review.edit')->middleware('check_permisson:review_edit');
	Route::post('/update', [AdminReviewController::class, 'update'])->name('admin.review.update')->middleware('check_permisson:review_edit');
	Route::get('/delete', [AdminReviewController::class, 'delete'])->name('admin.review.delete')->middleware('check_permisson:review_delete');
	Route::get('/search', [AdminReviewController::class, 'search'])->name('admin.review.search')->middleware('check_permisson:review_list');
});


Route::prefix('code')->group(function () {
	Route::get('/', [AdminCodeController::class, 'index'])->name('admin.code.index')->middleware('check_permisson:code_list');
	Route::get('/create', [AdminCodeController::class, 'create'])->name('admin.code.create')->middleware('check_permisson:code_create');
	Route::post('/store', [AdminCodeController::class, 'store'])->name('admin.code.store')->middleware('check_permisson:code_create');
	Route::get('/edit', [AdminCodeController::class, 'edit'])->name('admin.code.edit')->middleware('check_permisson:code_edit');
	Route::post('/update', [AdminCodeController::class, 'update'])->name('admin.code.update')->middleware('check_permisson:code_edit');
	Route::get('/delete', [AdminCodeController::class, 'delete'])->name('admin.code.delete')->middleware('check_permisson:code_delete');
	Route::get('/search', [AdminCodeController::class, 'search'])->name('admin.code.search')->middleware('check_permisson:code_list');
});

Route::prefix('combo')->group(function () {
	Route::get('/', [AdminComboController::class, 'index'])->name('admin.combo.index')->middleware('check_permisson:combo_list');
	Route::get('/create', [AdminComboController::class, 'create'])->name('admin.combo.create')->middleware('check_permisson:combo_create');
	Route::post('/store', [AdminComboController::class, 'store'])->name('admin.combo.store')->middleware('check_permisson:combo_create');
	Route::get('/edit', [AdminComboController::class, 'edit'])->name('admin.combo.edit')->middleware('check_permisson:combo_edit');
	Route::post('/update', [AdminComboController::class, 'update'])->name('admin.combo.update')->middleware('check_permisson:combo_edit');
	Route::get('/delete', [AdminComboController::class, 'delete'])->name('admin.combo.delete')->middleware('check_permisson:combo_delete');
	Route::get('/search', [AdminComboController::class, 'search'])->name('admin.combo.search')->middleware('check_permisson:combo_list');
});

Route::prefix('notification')->group(function () {
	// Đã nhận
	Route::get('/', [AdminNotificationController::class, 'index'])->name('admin.notification.index');
	Route::get('/read', [AdminNotificationController::class, 'read'])->name('admin.notification.read');
	// Đã gửi
	Route::get('/sent', [AdminNotificationController::class, 'sent'])->name('admin.notification.sent');
	Route::get('/create', [AdminNotificationController::class, 'create'])->name('admin.notification.create');
	Route::post('/store', [AdminNotificationController::class, 'store'])->name('admin.notification.store');
	Route::get('/edit', [AdminNotificationController::class, 'edit'])->name('admin.notification.edit');
	Route::post('/update', [AdminNotificationController::class, 'update'])->name('admin.notification.update');
	//Đã nhận
	Route::get('/delete', [AdminNotificationController::class, 'delete'])->name('admin.notification.delete');
	//Đã gửi
	Route::get('sent/delete', [AdminNotificationController::class, 'sentDelete'])->name('admin.notification.sent.delete');
	//Đã nhận
	Route::get('/search', [AdminNotificationController::class, 'search'])->name('admin.notification.search');
	//Đã gửi
	Route::get('sent/search', [AdminNotificationController::class, 'sentSearch'])->name('admin.notification.sent.search');
});

// Đang làm mục lục
Route::prefix('chapter')->group(function () {
	Route::get('/', [AdminChapterController::class, 'index'])->name('admin.chapter.index')->middleware('check_permisson:chapter_list');
	Route::get('/create', [AdminChapterController::class, 'create'])->name('admin.chapter.create')->middleware('check_permisson:chapter_create');
	Route::post('/store', [AdminChapterController::class, 'store'])->name('admin.chapter.store')->middleware('check_permisson:chapter_create');
	Route::get('/edit', [AdminChapterController::class, 'edit'])->name('admin.chapter.edit')->middleware(['check_permisson:chapter_edit', 'check_chapter_author']);
	Route::post('/update', [AdminChapterController::class, 'update'])->name('admin.chapter.update')->middleware(['check_permisson:chapter_edit', 'check_chapter_author']);
	Route::post('/delete', [AdminChapterController::class, 'delete'])->name('admin.chapter.delete')->middleware(['check_permisson:chapter_edit', 'check_chapter_author']);
	Route::post('/show', [AdminChapterController::class, 'show'])->name('admin.chapter.show');
});

// Đang report
Route::prefix('report')->group(function () {
	Route::get('/', [AdminReportController::class, 'index'])->name('admin.report.index')->middleware('check_permisson:report_list');
	Route::get('/update', [AdminReportController::class, 'update'])->name('admin.report.update')->middleware('check_permisson:report_update');
	Route::get('/search', [AdminReportController::class, 'search'])->name('admin.report.search')->middleware('check_permisson:report_list');
	Route::get('/delete', [AdminReportController::class, 'delete'])->name('admin.report.delete')->middleware('check_permisson:report_delete');
});

Route::get('search', [AdminSearchController::class, 'index'])->name('admin.search');
Route::get('search-popup', [AdminSearchController::class, 'searchPopup'])->name('admin.search.popup');

//Insert Data
Route::get('insert/teacher', [AdminDataController::class, 'insertTeacher']);
Route::get('update/teacher', [AdminDataController::class, 'updateTeacher']);
Route::get('insert/course', [AdminDataController::class, 'insertCourse']);
Route::get('insert/chapter', [AdminDataController::class, 'insertChapter']);
Route::get('update/slug', [AdminDataController::class, 'updateSlug']);
Route::get('insert/province', [AdminDataController::class, 'insertProvince']);

//Other
Route::get('help', function () {
	return view('about-us');
})->name('admin.help');

// Main route --> end