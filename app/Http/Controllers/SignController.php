<?php

namespace App\Http\Controllers;

use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SignController extends Controller
{
	public function signin(Request $request)
	{
		return view('sign.signin', ['alert' => $request->session()->get('alert')]);
	}

	public function signinSubmit(SigninRequest $request)
	{
		$userCredentials = $request->only('email', 'password');
		$user = User::where('email', $userCredentials['email'])->first();
		if ($user) {
			if ($user->status == 0) {
				return redirect()->route('signin')->with('alert', 'You need to verify your account before logging in');
			} else {
				if (Auth::attempt($userCredentials)) {
					return redirect()->route('index');
				}
			}
		}
		return back()->withInput()->withErrors([
			'email' => 'Invalid username or password.',
		]);
	}

	public function signup(Request $request)
	{
		return view('sign.signup');
	}

	public function signupSubmit(SignupRequest $request)
	{
		$token = Str::random(20);
		$name = $request->name;
		$user = User::create([
			'name' => $name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'thumbnail' => "/images/user.png",
			'token' => $token
		]);
		$user->roles()->attach(2);
		Mail::send('verify', compact('user'), function ($message) use ($user) {
			$message->to($user->email, $user->name)
				->subject('Confirm your email address for Starclasses.edu.vn');
		});
		return redirect()->route('signin')->with('alert', 'You need to verify your account before logging in');
	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('index');
	}

	//Google
	function redirectToGoogle(Request $request)
	{
		return Socialite::driver('google')->redirect();
	}

	function handleGoogleCallback(Request $request)
	{
		$user = Socialite::driver('google')->user();

		$existingUser = User::where('email', $user->getEmail())->first();

		if ($existingUser) {
			Auth::login($existingUser);
		} else {
			$newUser = new User();
			$newUser->name = $user->getName();
			$newUser->email = $user->getEmail();
			$newUser->password = bcrypt(Str::random(16));
			$newUser->save();
			// Update slug
			$newUser->update([
				'slug' => Str::slug($newUser->name, '-') . '-' . $newUser->id,
			]);
			// Add role cho nó
			$newUser->roles()->attach(['2']);
			Auth::login($newUser);
		}
		return redirect()->route('index');
	}
}
