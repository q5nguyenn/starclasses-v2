<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{
	public function index(Request $request)
	{
		dd("cart.index");
	}
	public function store(Request $request)
	{
		$user = Auth::user();
		$carts = Cart::where('user_id', $user->id)
			->where('course_id', $request->id)->get();
		if ($carts->count() == 0) {
			Cart::create([
				'user_id' => $user->id,
				'course_id' => $request->id
			]);
		}
		return response()->json([
			'code' => 200,
			'message' => 'success',
		], 200);
	}
	public function delete(Request $request)
	{
		$cart = Cart::find($request->id);
		if (Gate::allows('delete', $cart)) {
			$cart->delete();
		} else {
			abort(403);
		}
	}
}
