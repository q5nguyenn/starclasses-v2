<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailController extends Controller
{
	function verify(Request $request)
	{
		$user = User::find($request->user_id);
		if ($user->token == $request->token) {
			$user->update([
				'status' => 1
			]);
			return redirect()->route('signin')->with('alert', 'Email verification successful');;
		} else {
			return redirect()->route('signin')->with('alert', 'Account verification failed');
		}
	}
}
