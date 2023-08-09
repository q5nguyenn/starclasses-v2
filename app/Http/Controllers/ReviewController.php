<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ReviewController extends Controller
{
	public function index(Request $request)
	{
		$page = $request->input('page');
		$course_id = $request->input('course_id');
		$reviews = Review::select('reviews.*', 'users.name as user_name', 'users.thumbnail as thumbnail')
			->join('courses', 'courses.id', '=', 'reviews.course_id')
			->join('users', 'reviews.user_id', '=', 'users.id')
			->where('courses.id', $course_id)
			->where('reviews.status', '!=', 2)
			->orderBy('created_at', 'desc')
			->get();
		if (($page + 1) * 2 > count($reviews)) {
			return response()->json([
				'data' => $reviews,
				'status' => "-1"
			]);
		} else {
			return response()->json(
				[
					'data' => $reviews->take(($page + 1) * 2),
					'status' => "1"
				]
			);
		}
	}


	public function store(ReviewRequest $request)
	{
		$reviewData = [
			'content' => $request->content,
			'rate' => $request->rate,
			'course_id' => $request->course_id,
			'user_id' => $request->user_id,
			'status' => 1
		];
		Review::updateOrCreate(
			[
				'user_id' => Auth::id(),
				'course_id' => $request->course_id
			],
			$reviewData
		);
		return back();
	}


	public function report(Request $request)
	{
		$review = Review::find($request->id);
		$review->update([
			'status' => 0
		]);
	}
}
