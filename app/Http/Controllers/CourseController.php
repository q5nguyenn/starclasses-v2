<?php

namespace App\Http\Controllers;

use App\Models\BillCourse;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class CourseController extends Controller
{
	public function index(Request $request)
	{
		$slug = $request->slug;
		// $parts = explode("-", $slug);
		// $id = end($parts);
		$login = Auth::check();
		$course = Course::where('slug', $slug)->first();
		if (!$course) {
			abort(404);
		}
		$id = $course->id;
		$like = false;
		$buyCourse = false;
		$cartCourse = false;
		if (Auth::check()) {
			$user = Auth::user();
			$wishlists = Wishlist::where('user_id', $user->id)
				->where('course_id', $id)->get();
			if (count($wishlists) != 0) {
				$like = true;
			}
			$buyCourses = BillCourse::join('bills', 'bills.id', '=', 'bill_course.bill_id')
				->where('user_id', $user->id)
				->where('course_id', $id)->get();
			if (count($buyCourses) != 0) {
				$buyCourse = true;
			}
			$cartCourses = Cart::where('user_id', $user->id)
				->where('course_id', $id)->get();
			if (count($cartCourses) != 0) {
				$cartCourse = true;
			}
		}
		$relatedCourses = Course::where('department_id', $course->department_id)
			->where('courses.id', '!=', $course->id)
			->take(5)->get();
		$reviews = $course->reviews()
			->where('reviews.status', '!=', 2)
			->orderBy('updated_at', 'desc')
			->get();
		$reviewCount = count($reviews);
		$reviews = $reviews->take(2);
		$chapters = $course->chapters;
		$parts = count($chapters);
		foreach ($chapters as $chapter) {
			if ($chapter->parent_id == 0) $parts--;
		}
		return view('course', [
			'course' => $course,
			'like' => $like,
			'relatedCourses' => $relatedCourses,
			'reviews' => $reviews,
			'buyCourse' => $buyCourse,
			'cartCourse' => $cartCourse,
			'login' => $login,
			'reviewsCount' => $reviewCount,
			'chapters' => $chapters,
			'parts' => $parts
		]);
	}
}
