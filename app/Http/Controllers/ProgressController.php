<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
	function update(Request $request)
	{
		$user = Auth::user();
		$chapter_id = $request->chapter_id;
		$user_id = $user->id;
		$progress = Progress::where('progress.chapter_id', $chapter_id)
			->where('progress.user_id', $user_id)->first();
		$progress->update([
			'completed' => 1
		]);
	}
}
