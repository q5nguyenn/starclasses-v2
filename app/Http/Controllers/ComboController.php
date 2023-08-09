<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ComboController extends Controller
{
	function index(Request $request)
	{
		$slug = $request->slug;
		$combo = Combo::where('slug', $slug)->first();
		if (!$combo) {
			abort(404);
		}
		$now = Carbon::now();
		$endDate = Carbon::parse($combo->expiration_date);

		// Kiểm tra nếu endate đã hết hạn so với ngày hiện tại
		if ($now > $endDate) {
			return view('errors.index', [
				'alert' => 'Course combo has expired',
				'content' => 'Sorry for the inconvenience'
			]);
		}
		$user = $combo->courses()->first()->user;
		$primaryPrice = $combo->primaryPrice();
		$discount = $combo->discountPercent();
		return view('combo', [
			'combo' => $combo,
			'user' => $user,
			'primaryPrice' => $primaryPrice,
			'discount' => $discount
		]);
	}
}
