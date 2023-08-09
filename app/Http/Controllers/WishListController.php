<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WishListController extends Controller
{
	public function index(Request $request)
	{
	}
	public function create(Request $request)
	{
		$user = Auth::user();
		$wishlist = Wishlist::where('user_id', $user->id)
			->where('course_id', $request->id)->get();
		if ($wishlist->count() == 0) {
			Wishlist::create([
				'user_id' => $user->id,
				'course_id' => $request->id
			]);
		}
		return response()->json([
			'code' => 200,
			'message' => 'success',
			'data' => $wishlist
		], 200);
	}

	public function delete(Request $request)
	{

		$wishlist = Wishlist::where('course_id', $request->id)
			->where('user_id', Auth::id())->first();
		if (Gate::allows('delete', $wishlist)) {
			$wishlist->delete();
		} else {
			abort(403);
		}
	}
}
