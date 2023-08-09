<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminSearchController extends Controller
{
	public function index(Request $request)
	{
		$value = $request->value;
		// $courses = Course::where('name', 'LIKE', '%' . $value . '%')->get();
		$courses = DB::table('courses')
			->select('id', 'name', DB::raw("'course' as field"))
			->where('name', 'LIKE', '%' . $value . '%');
		$results = DB::table('users')
			->select('id', 'name', DB::raw("'user' as field"))
			->where('name', 'LIKE', '%' . $value . '%')
			->union($courses)
			->take(10)
			->get();
		return $results;
		// return response()->json([
		// 	'code' => '200',
		// 	'data' => $results
		// ], 200);
	}

	//Search
	public function searchPopup(Request $request)
	{
		$user = Auth::user();
		$keyword = $request->keyword;
		$courses = Course::select('id', 'name')
			->selectRaw("'course' as field")
			->where('name', 'LIKE', '%' . $keyword . '%');
		if ($user->isVip()) {
			$users = User::select('id', 'name')
				->selectRaw("'user' as field")
				->where('name', 'LIKE', '%' . $keyword . '%');
			$results = $courses->union($users)->orderBy('name');
		} else {
			$results = $courses->where('courses.teacher_id', $user->id);
		}
		$results = $results->orderBy('name')->take(10)->get();
		return $results;
	}
}
