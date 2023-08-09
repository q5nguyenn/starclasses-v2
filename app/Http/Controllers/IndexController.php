<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\OnlineUser;
use App\Models\Slider;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
	public function index(Request $request)
	{
		//Thêm người truy cập
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$visitor = Visitor::where('ip_address', $ipAddress)->first();
		if (!$visitor) {
			$visitor = new Visitor();
			$visitor->ip_address = $ipAddress;
			$visitor->user_agent = $userAgent;
			$visitor->save();
		}
		// Đếm số người truy cập Online
		$sessionId = session()->getId();
		// Kiểm tra xem session ID đã tồn tại trong bảng "online_users" hay chưa
		$existingUser = OnlineUser::where('session_id', $sessionId)->first();
		if ($existingUser) {
			$existingUser->last_activity = now();
			$existingUser->save();
		} else {
			$newUser = new OnlineUser();
			$newUser->session_id = $sessionId;
			$newUser->last_activity = now();
			$newUser->save();
		}
		// Nhân viên hỗ trợ
		$employee = User::join('role_user', 'users.id', '=', 'role_user.user_id')
			->where('role_user.role_id', 5)
			->first();
		$conversation = Conversation::where('employee_unique_id', $employee->unique_id)
			->where('guest_unique_id', $visitor->unique_id)->first();
		$hasConversation = false;
		if ($conversation) {
			$hasConversation = true;
		}
		//Slider
		$sliders = Slider::all();
		$bestSeller = Course::select('*')
			->selectRaw("round((price - discount)/price*100) AS discount_percent")
			->orderBy('discount_percent', 'desc')
			->take(4)
			->get();
		$buisinessaAndStartup = Faculty::find(5)->courses()->take(4)->get();
		//Giảng viên hot
		$typicalTeacher = User::select('users.*')
			->join('courses', 'users.id', '=', 'courses.teacher_id')
			->leftjoin('bill_course', 'courses.id', '=', 'bill_course.course_id')
			->selectRaw('COUNT(users.id) as students')
			->groupBy('users.id')
			->orderByDesc('students')
			->take(6)
			->get();
		// Mới nhất
		$newReleases = Course::orderBy('created_at')->take(9)->get();
		//Phổ biến nhất
		$mostPopular = Course::select('courses.*')
			->leftJoin('bill_course', 'courses.id', '=', 'bill_course.course_id')
			->selectRaw('COUNT(courses.id) as students')
			->groupBy('courses.id')
			->orderByDesc('students')
			->take(9)
			->get();

		$vipCourses = Course::join('course_tag', 'courses.id', '=', 'course_tag.course_id')
			->where('course_tag.tag_id', 5)
			->select('courses.*')
			->take(9)
			->get();
		return view('index', [
			'sliders' => $sliders,
			'bestSeller' => $bestSeller,
			'buisinessaAndStartup' => $buisinessaAndStartup,
			'typicalTeacher' => $typicalTeacher,
			'newReleases' => $newReleases,
			'mostPopular' => $mostPopular,
			'vipCourses' => $vipCourses,
			'hasConversation' => $hasConversation
		]);
	}

	//Contact
	public function becomeTeacher(Request $request)
	{
		return view('become-teacher');
	}

	public function aboutUs(Request $request)
	{
		return view('about-us');
	}

	public function term(Request $request)
	{
		return view('terms');
	}
}
