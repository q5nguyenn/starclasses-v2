<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SignController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishListController;
use App\Models\NotificationUser;
use App\Models\OnlineUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

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

//Signin
Route::get('signin', [SignController::class, 'signin'])->name('signin');
Route::post('signin/submit', [SignController::class, 'signinSubmit'])->name('signin.submit');

//Login Google
Route::get('/signin/google', [SignController::class, 'redirectToGoogle'])->name('signin.google');
Route::get('/signin/google/callback', [SignController::class, 'handleGoogleCallback'])->name('signin.google.calback');

//Signup
Route::get('signup', [SignController::class, 'signup'])->name('signup');
Route::post('signup/submit', [SignController::class, 'signupSubmit'])->name('signup.submit');

//Mail
Route::get('verify', [EmailController::class, 'verify'])->name('activation.verify');

// Password
Route::get('password/forgot', [PasswordController::class, 'forgot'])->name('password.forgot');
Route::post('password/send', [PasswordController::class, 'send'])->name('password.send');
Route::get('password/change', [PasswordController::class, 'change'])->name('password.change');
Route::post('password/reset', [PasswordController::class, 'reset'])->name('password.reset');

//Logout
Route::get('logout', [SignController::class, 'logout'])->name('logout');

//Index
Route::get('', [IndexController::class, 'index'])->name('index');
Route::get('faculty/{slug}', [FacultyController::class, 'index'])->name('faculty');
Route::get('faculty/{slug}/sort', [FacultyController::class, 'sort'])->name('faculty.sort');
Route::get('department/{slug}', [DepartmentController::class, 'index'])->name('department');
Route::get('department/{slug}/sort', [DepartmentController::class, 'sort'])->name('department.sort');
Route::get('course/{slug}', [CourseController::class, 'index'])->name('course');

//User
Route::get('teacher/{slug}', [UserController::class, 'index'])->name('teacher')->middleware('check.teacher');
Route::get('profile/{slug}', [UserController::class, 'profile'])->name('profile')->middleware(['auth']);
Route::post('profile/changepassword', [UserController::class, 'changePassword'])->name('profile.changepassword')->middleware(['auth']);
Route::post('profile/update', [UserController::class, 'update'])->name('profile.update')->middleware(['auth']);

//Contact
Route::get('become-teacher', [IndexController::class, 'becomeTeacher'])->name('become.teacher');
Route::get('about-us', [IndexController::class, 'aboutUs'])->name('about.us');
Route::get('term', [IndexController::class, 'term'])->name('term');

//Search
Route::get('search-popup', [SearchController::class, 'searchPopup'])->name('search.popup');
Route::get('search', [SearchController::class, 'index'])->name('search');
Route::get('search-by', [SearchController::class, 'searchBy'])->name('search.by');

//Wishlist
Route::prefix('wishlist')->group(function () {
	Route::get('/', [WishListController::class, 'index'])->name('wishlist.index');
	Route::get('/store', [WishListController::class, 'create'])->name('wishlist.store');
	Route::get('/delete', [WishListController::class, 'delete'])->name('wishlist.delete');
});
//Review
Route::prefix('review')->group(function () {
	Route::get('/', [ReviewController::class, 'index'])->name('review.index');
	Route::post('/store', [ReviewController::class, 'store'])->name('review.store')->middleware(['auth']);
	Route::get('/report', [ReviewController::class, 'report'])->name('review.report');
});

//Cart
Route::prefix('cart')->group(function () {
	Route::get('/', [CartController::class, 'index'])->name('cart.index');
	Route::get('/store', [CartController::class, 'store'])->name('cart.store');
	Route::get('/delete', [CartController::class, 'delete'])->name('cart.delete');
});

//Checkout
Route::prefix('checkout')->group(function () {
	Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index')->middleware(['auth']);
	Route::get('/now/{slug}', [CheckoutController::class, 'indexNow'])->name('checkout-now.index')->middleware(['auth']);
	Route::get('/now/combo/{slug}', [CheckoutController::class, 'indexComboNow'])->name('checkout-now.combo.index')->middleware(['auth']);
	Route::get('/payment', [CheckoutController::class, 'payment'])->name('checkout.payment')->middleware(['auth']);
	Route::get('/payment-now', [CheckoutController::class, 'paymentNow'])->name('checkout.payment.now')->middleware('auth');
	Route::get('combo/payment-now', [CheckoutController::class, 'paymentComboNow'])->name('checkout.combo.payment.now')->middleware('auth');
	Route::get('/new', [CheckoutController::class, 'new'])->name('checkout.new');
});

//Checkout
Route::prefix('combo')->group(function () {
	Route::get('/{slug}', [ComboController::class, 'index'])->name('combo.index');
});

//Progress
Route::get('progress/update', [ProgressController::class, 'update'])->name('progress.update')->middleware(['auth']);

//Code
Route::get('code/active', [CodeController::class, 'active'])->name('code.active')->middleware(['auth']);


//Notification
Route::prefix('notification')->group(function () {
	Route::get('/update', [NotificationController::class, 'update'])->name('notification.update');
	Route::get('/create', [NotificationController::class, 'create'])->name('notification.create');
	Route::post('/store', [NotificationController::class, 'store'])->name('notification.store');
	Route::get('/edit', [NotificationController::class, 'edit'])->name('notification.edit');
	Route::post('/save', [NotificationController::class, 'save'])->name('notification.save');
	Route::get('/delete', [NotificationController::class, 'delete'])->name('notification.delete');
	Route::get('/sent/delete', [NotificationController::class, 'sentDelete'])->name('notification.sent.delete');
});

//Notification
Route::post('report', [ReportController::class, 'report'])->name('report');

//Report
Route::prefix('count')->group(function () {
	Route::get('/online-user', [CountController::class, 'onlineUser'])->name('count.online.user');
});


// Support
Route::prefix('conversation')->group(function () {
	Route::get('/get-employee', [ConversationController::class, 'getEmployee'])->name('conversation.get-employee');
	Route::get('/message/creat', [ConversationController::class, 'createMessage'])->name('conversation.massage.create');
	Route::get('/message/get', [ConversationController::class, 'getMessage'])->name('conversation.massage.get');
});

// Main route --> end