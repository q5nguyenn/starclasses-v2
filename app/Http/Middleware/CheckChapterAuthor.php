<?php

namespace App\Http\Middleware;

use App\Models\Chapter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckChapterAuthor
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$chapterId = $request->id;
		$chapter = Chapter::find($chapterId);
		$user = Auth::user();
		if ($user->isVip()) {
			return $next($request);
		}
		if ($chapter->course->user->id == Auth::id()) {
			return $next($request);
		} else {
			return abort(403);
		}
	}
}
