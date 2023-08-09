<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminReviewController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$list = Review::Paginate(10);
		$count  =  $this->numberDisplay(count(Review::get()));
		return view('admin.review.index', [
			'list' => $list,
			'count' => $count
		]);
	}

	public function create(Request $request)
	{
		$users = User::all();
		$courses =  Course::all();
		return view('admin.review.create', [
			'users' => $users,
			'courses' => $courses
		]);
	}

	public function store(ReviewRequest $request)
	{
		$review = Review::create([
			'content' => $request->content,
			'rate' => $request->rate,
			'status' => $request->status,
			'course_id' => $request->course_id,
			'user_id' => $request->user_id,
		]);
		return redirect()->route('admin.review.index');
	}

	public function edit(Request $request)
	{
		$review = Review::find($request->id);
		$users = User::all();
		$courses =  Course::all();
		return view('admin.review.edit', [
			'users' => $users,
			'courses' => $courses,
			'review' => $review
		]);
	}

	public function update(ReviewRequest $request)
	{
		$review = Review::find($request->id);
		$review->update([
			'content' => $request->content,
			'rate' => $request->rate,
			'status' => $request->status,
			'course_id' => $request->course_id,
			'user_id' => $request->user_id,
		]);
		return redirect()->route('admin.review.index');
	}

	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$review = Review::find($request->id);
			if ($review) {
				$review->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Review not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete review because there are related somethings!'
			]);
		}
	}

	public function search(Request $request)
	{
		$status = $request->status;
		$query = Review::join('users', 'users.id', '=', 'reviews.user_id')
			->join('courses', 'courses.id', '=', 'reviews.course_id')
			->where(function ($query) use ($request) {
				$query->where('courses.name', 'like', '%' . $request->keyword . '%')
					->orWhere('users.email', 'like', '%' . $request->keyword . '%');
			});
		if ($status != '') {
			$query->where('reviews.status', '=', $status);
		}
		$query->select('reviews.*', 'users.name', 'courses.name');
		$list = $query;
		$count = $this->numberDisplay(count($list->get()));
		$list = $list->paginate(10);
		return view('admin.review.index', [
			'list' => $list,
			'count' => $count,
			'keyword' => $request->keyword,
			'status' => $status
		]);
	}
}
