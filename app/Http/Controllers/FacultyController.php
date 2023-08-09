<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Faculty;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$sort_by = $request->sort_by ?? '';
		$star = $request->star ?? '';
		$page = $request->page ?? '';
		$view_more = false;
		$end_page = false;
		$faculty = Faculty::where('slug', $request->slug)->first();
		if (!$faculty) {
			abort(404);
		}
		$mostPopular = $faculty->courses()
			->select('courses.*')
			->join('bill_course', 'courses.id', '=', 'bill_course.course_id')
			->selectRaw('COUNT(courses.id) as students')
			->groupBy('courses.id')
			->orderByDesc('students')
			->take(3)
			->get();
		$newest = $faculty->courses()
			->orderByDesc('created_at')
			->take(6)
			->get();
		$query = $this->sortBy($faculty->courses(), $sort_by, $star);
		$totalCourse = $query->get();
		$totalItem = count($totalCourse);
		$pages  = intval($totalItem / 5);
		if ($totalItem > 5) {
			$view_more = true;
		}
		$count = (intval($page) + 1) * 5;
		if (intval($page) + 1 > floor($totalItem / 5)) {
			$end_page = true;
		}
		$courses = $query->take($count)->get();
		return view('faculty', [
			'faculty' => $faculty,
			'courses' => $courses,
			'sort_by' => $sort_by,
			'star' => $star,
			'count' => count($totalCourse),
			'view_more' => $view_more,
			'end_page' => $end_page,
			'mostPopular' => $mostPopular,
			'newest' => $newest
		]);
	}
	public function sort(Request $request)
	{
		$sort_by = $request->sort_by ?? '';
		$star = $request->star ?? '';
		$page = $request->page ?? '';
		$view_more = false;
		$end_page = false;
		$faculty = Faculty::where('slug', $request->slug)->first();
		$mostPopular = $faculty->courses()
			->select('courses.*')
			->leftJoin('bill_course', 'bill_course.course_id', '=', 'courses.id')
			->selectRaw('count(*) as students')
			->groupBy('courses.id')
			->orderByDesc('students')
			->take(6)
			->get();
		$newest = $faculty->courses()
			->orderByDesc('created_at')
			->take(6)
			->get();
		$query = $this->sortBy($faculty->courses(), $sort_by, $star);
		$totalCourse = $query->get();
		$totalItem = count($totalCourse);
		$pages  = intval($totalItem / 5);
		if ($totalItem > 5) {
			$view_more = true;
		}
		$count = (intval($page) + 1) * 5;
		if (intval($page) + 1 > floor($totalItem / 5)) {
			$end_page = true;
		}
		$courses = $query->take($count)->get();
		return response()->json($courses);
	}
}
