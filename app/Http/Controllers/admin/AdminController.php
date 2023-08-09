<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Models\Bill;
use App\Models\Course;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
	public function index(Request $request)
	{
		if (!Auth::check()) {
			return view('admin/signin');
		};
		$users = User::all();
		$visitors = Visitor::count();
		$bills = Bill::all();
		$totalSales = 0;
		foreach ($bills as $bill) {
			$totalSales += $bill->totalDiscount();
		}
		$query = Course::leftJoin('bill_course', 'courses.id', '=', 'bill_course.course_id');
		$query->selectRaw('courses.*, count(*) as students')
			->groupBy('courses.id')
			->orderBy('students', 'desc');
		$courses = $query->take(5)->get();
		return view('admin.home', [
			'users' => $users,
			'visitors' => $visitors,
			'bills' => $bills,
			'totalSales' => $totalSales,
			'courses' => $courses
		]);
	}

	public function login(SigninRequest $request)
	{
		dd(1);
		// return view('admin.signin');
	}

	public function postLogin(SigninRequest $request)
	{
		$user = $request->only('email', 'password');
		// dd($user);
		if (Auth::attempt($user)) {
			return redirect()->route('admin.index');
		} else {
			return back()->withInput()->withErrors([
				'email' => 'Invalid username or password.',
			]);
		}
	}

	public function signout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('index');
	}
}
