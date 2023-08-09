<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{

	public function forgot(Request $request)
	{
		return view('password.forgot');
	}

	public function send(Request $request)
	{
		$request->validate([
			'email' => 'required|email|min:6|exists:users,email',
		], [
			'email.required' => '*Email field cannot be left blank.',
			'email.email' => '*Email is invalid.',
			'email.min' => '*Email must contain at least 6 characters.',
			'email.exists' => '*Email does not exists.',
		]);
		$token = Str::random(20);
		$email = $request->email;
		$user = User::where('email', $request->email)->first();
		$user->update([
			'token' => $token
		]);
		Mail::send('password.send', compact('user'), function ($message) use ($user) {
			$message->to($user->email, $user->name)
				->subject('Change password for Starclasses.edu.vn');
		});
		return redirect()->route('signin')->with('alert', 'Please check your email and confirm the password change');
	}

	public function change(Request $request)
	{
		$user = User::find($request->user_id);
		if ($user->token == $request->token) {
			return view('password/reset', ['user' => $user]);
		} else {
			// return redirect()->route('signin')->with('error', 'Account verification failed');
			return view('errors.index', [
				'alert' => 'Email verification failed',
				'content' => 'Invalid or expired reset password token. Please try again or request a new password reset.'
			]);
		}
	}

	public function reset(Request $request)
	{
		$request->validate([
			'password' => 'bail|required|min:6|confirmed',
		], [
			'password.required' => '*Password field cannot be left blank.',
			'password.min' => '*Password must contain at least 5 characters.',
			'password.confirmed' => '*Password do not match.',
		]);
		$user = User::find($request->user_id);
		$password = $request->password;
		$user->update([
			'password' => Hash::make($password)
		]);
		return redirect()->route('signin')->with('alert', 'Password update successful');
	}
}
