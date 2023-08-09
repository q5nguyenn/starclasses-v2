<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Traits\Utilities;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

class SearchController extends Controller
{
	use Utilities;
	//Search
	public function searchPopup(Request $request)
	{
		$keyword = $request->keyword;
		$courses = DB::table('courses')
			->select('id', 'name', 'slug', DB::raw("'course' as field"))
			->where('name', 'LIKE', '%' . $keyword . '%');
		$results = DB::table('users')
			->select('id', 'name', 'slug', DB::raw("'teacher' as field"))
			->where('name', 'LIKE', '%' . $keyword . '%')
			->union($courses)
			->orderBy('name')
			->take(10)
			->get();
		return $results;
	}
	//Search Sort
	public function index(Request $request)
	{
		//most popular - most star - new west - price - rating
		$keyword = $request->keyword ?? '';
		$sort_by = $request->sort_by ?? '';
		$star = $request->star ?? '';
		$page = $request->page ?? '';
		if ($request->has('desc')) {
			$desc = $request->desc;
		} else {
			$desc = null;
		}
		$view_more = false;
		$end_page = false;

		$query = Course::where('courses.name', 'like', '%' . $keyword . '%');
		$query = $this->sortBy($query, $sort_by, $star);
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
		// return response()->json($courses);
		return view('search', [
			'courses' => $courses,
			'keyword' => $keyword,
			'sort_by' => $sort_by,
			'star' => $star,
			'count' => count($totalCourse),
			'view_more' => $view_more,
			'end_page' => $end_page,
			'desc' => $desc
		]);
	}


	//Search Sort
	public function searchBy(Request $request)
	{
		//most popular - most star - new west - price - rating
		$keyword = $request->keyword ?? '';
		$sort_by = $request->sort_by ?? '';
		$star = $request->star ?? '';
		$page = $request->page ?? '';
		$view_more = false;
		$end_page = false;
		$query = Course::where('courses.name', 'like', '%' . $keyword . '%');
		$query = $this->sortBy($query, $sort_by, $star);
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

		$formattedCourses = $courses->map(function ($course) {
			$course->star = round($course->star, 1);
			return $course;
		});

		return response()->json($formattedCourses);
	}
}
