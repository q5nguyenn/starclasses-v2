<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\BillCourse;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Province;
use App\Models\User;
use App\Models\Wishlist;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Utilities;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$slug = $request->slug;
		// $parts = explode("-", $slug);
		// $id = end($parts);
		$user = User::where('slug', $slug)->first();
		if (!$user) {
			abort(404);
		}
		return view('teacher', [
			'user' => $user
		]);
	}

	public function profile(Request $request)
	{
		$slug = $request->slug;
		switch ($slug) {
			case 'infomation':
				$frame = 0;
				break;
			case 'learning':
				$frame = 1;
				break;
			case 'active-code':
				$frame = 2;
				break;
			case 'support-request':
				$frame = 3;
				break;
			case 'order-history':
				$frame = 4;
				break;
			case 'wishlist':
				$frame = 5;
				break;
			case 'notification':
				$frame = 6;
				break;
			case 'send':
				$frame = 7;
				break;
			case 'change-password':
				$frame = 8;
				break;
			default:
				$frame = 0;
				break;
		}
		$provinces = Province::all();
		$user = Auth::user();
		$carts = $user->carts;
		$wishlists = $user->wishlists;
		$users = User::all();
		$send_notifications = $user->notifications->sortByDesc('created_at');
		$buyCourses = Course::select('courses.*')
			->join('bill_course', 'courses.id', '=', 'bill_course.course_id')
			->join('bills', 'bill_course.bill_id', '=', 'bills.id')
			->where('user_id', $user->id)->get();
		$notifications = Notification::select('notifications.*', 'notification_user.id as notifications_userID')
			->join('notification_user', 'notifications.id', '=', 'notification_user.notification_id')
			->where('notification_user.user_id', $user->id)
			->orderBy('created_at', 'desc')
			->paginate(10);
		return view('profile', [
			'user' => $user,
			'users' => $users,
			'provinces' => $provinces,
			'frame' => $frame,
			'carts' => $carts,
			'wishlists' => $wishlists,
			'buyCourses' => $buyCourses,
			'notifications' => $notifications,
			'send_notifications' => $send_notifications
		]);
	}

	public function update(Request $request)
	{
		$user = User::find($request->id);
		$rules = [
			'name' => 'bail|required|min:5|max:100',
			'email' => [
				'required',
				'email',
				Rule::unique('users', 'email')->ignore($user),
			],
			'phone_number' => [
				'nullable',
				'regex:/^(0)?[0-9]{9}$/',
				Rule::unique('users', 'phone_number')->ignore($user),
			],
			'thumbnail' => [
				'nullable',
				'image',
				'max:500', // Max file size in kilobytes (KB)
			],
		];

		$customMessages = [
			'name.required' => '*Name field cannot be left blank.',
			'name.min' => '*Username must contain at least 5 and 100 characters.',
			'name.max' => '*Username must contain at least 5 and 100 characters.',
			'email.required' => '*Email field cannot be left blank.',
			'email.email' => '*Email invalidate.',
			'email.unique' => '*Email already exists.',
			'phone_number.unique' => '*Phone number already exists.',
			'phone_number.regex' => '*Phone number invalidate.',
			'thumbnail.image' => '*The file must be an image.',
			'thumbnail.max' => '*The image size must be smaller than 500KB.',
		];

		$request->validate($rules, $customMessages);
		$user = User::find($request->id);
		$url = $this->storeUpload($request, 'thumbnail', 'thumbnails');
		if (empty($url)) {
			$url = $user->thumbnail;
		} else {
			$this->deleteFile($user->thumbnail);
		}
		$user->update([
			'thumbnail' => $url,
			'description' => $request->description,
			'name' => $request->name,
			'email' => $request->email,
			'birth_day' => $request->birth_day,
			'phone_number' => $request->phone_number,
			'province_id' => $request->province_id,
		]);
		$user->update([
			'slug' => Str::slug($user->name, '-') . '-' . $user->id,
		]);
		return back()->with('Alert', true);
	}

	public function changePassword(PasswordRequest $request)
	{
		$user = User::find(Auth::id());
		$password = $request->password;
		$password_new = $request->password_new;

		if (Hash::check($password, $user->password)) {
			$user->update([
				'password' => Hash::make($password_new)
			]);
			return redirect()->route('signin')->with('alert', 'Change password successfully');
		} else {
			return back()->withInput()->withErrors(['password' => '*Incorrect password.']);
		}
	}
}
