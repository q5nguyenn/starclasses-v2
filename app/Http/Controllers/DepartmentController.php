<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Traits\Utilities;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$sort_by = $request->sort_by ?? '';
		$star = $request->star ?? '';
		$page = $request->page ?? '';
		$view_more = false;
		$end_page = false;
		$department = Department::where('slug', $request->slug)->first();
		if (!$department) {
			abort(404);
		}
		$mostPopular = $department->courses()
			->select('courses.*')
			->join('bill_course', 'bill_course.course_id', '=', 'courses.id')
			->selectRaw('count(*) as students')
			->groupBy('courses.id')
			->orderByDesc('students')
			->take(6)
			->get();
		$newest = $department->courses()
			->orderByDesc('created_at')
			->take(6)
			->get();
		$query = $this->sortBy($department->courses(), $sort_by, $star);
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
		return view('department', [
			'department' => $department,
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
		$department = Department::where('slug', $request->slug)->first();
		$mostPopular = $department->courses()
			->select('courses.*')
			->join('bill_course', 'bill_course.course_id', '=', 'courses.id')
			->selectRaw('count(*) as students')
			->groupBy('courses.id')
			->orderByDesc('students')
			->take(6)
			->get();
		$newest = $department->courses()
			->orderByDesc('created_at')
			->take(6)
			->get();
		$query = $this->sortBy($department->courses(), $sort_by, $star);
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
