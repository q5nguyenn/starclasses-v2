<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCourseAuthor
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$courseId = $request->id;
		$course = Course::find($courseId);
		$user = Auth::user();
		if ($user->isVip()) {
			return $next($request);
			return true;
		} else if ($course->teacher_id == Auth::id()) {
			return $next($request);
		} else {
			return redirect()->route('course.index');
		}
	}
}
