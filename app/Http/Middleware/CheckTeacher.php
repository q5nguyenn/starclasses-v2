<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckTeacher
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$slug = $request->slug;
		$parts = explode("-", $slug);
		$id = end($parts);
		$user = User::find($id);
		try {
			if ($user->roles->contains('name', 'Teacher')) {
				return $next($request);
			} else {
				abort(404);
			}
		} catch (\Throwable $th) {
			abort(404);
		}
	}
}
