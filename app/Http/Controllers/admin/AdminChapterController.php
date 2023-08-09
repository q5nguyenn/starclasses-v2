<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminChapterController extends Controller
{
	public function index(Request $request)
	{
		$user = Auth::user();
		if ($user->isVip()) {
			$courses = Course::all();
		} else {
			$courses = Course::where('teacher_id', $user->id)->get();
		}
		if ($request->has('course_id')) {
			$id = $request->course_id;
			$course = Course::find($id);
			$chapters = $course->chapters()->orderBy('content')->get();
			return view('admin.chapter.index', [
				'all' => false,
				'course' => $course,
				'chapters' => $chapters
			]);
		} else {
			return view('admin.chapter.index', [
				'all' => true,
				'courses' => $courses,
			]);
		}
	}

	public function create(Request $request)
	{
		$user = Auth::user();
		if ($user->isVip()) {
			$courses = Course::all();
		} else {
			$courses = Course::where('teacher_id', $user->id)->get();
		}
		$chaterParent = Chapter::find($request->parent_id);
		return view('admin.chapter.create', [
			'courses' => $courses,
			'course_id' => $request->course_id,
			'chaterParent' => $chaterParent
		]);
	}
	public function store(Request $request)
	{
		if ($request->parent_id == 0) {
			Chapter::create([
				'content' => $request->content,
				'parent_id' => 0,
				'course_id' => $request->course_id
			]);
		} else {

			Chapter::create([
				'content' => $request->content,
				'parent_id' => $request->parent_id,
				'video_link' => $request->video_link,
				'course_id' => $request->course_id
			]);
		}
		return redirect()->back()->with('scrollPosition', 'restoreScrollPosition()');
	}

	public function edit(Request $request)
	{
		$id = $request->id;
		$chapter = Chapter::find($id);
		if ($chapter) {
			return $chapter;
		} else {
			abort(401);
		}
	}

	public function update(ChapterRequest $request)
	{
		$chapter = Chapter::find($request->id);
		$chapter->update([
			'content' => $request->content,
			'video_link' => $request->video_link,
		]);
		return redirect()->back()->with('scrollPosition', 'restoreScrollPosition()');
	}

	public function delete(Request $request)
	{
		$id = $request->id;
		$chapter = Chapter::find($id);
		$chapters = $chapter->chapterChilds;
		if (!$chapters) {
			$chapter->delete();
		} else {
			foreach ($chapters as $chapter_child) {
				$chapter_child->delete();
			}
			$chapter->delete();
		}
		return redirect()->back()->with('scrollPosition', 'restoreScrollPosition()');
	}
	public function show(Request $request)
	{
		$id = $request->course_id;
		$course = Course::find($id);
		$chapters = $course->chapters()
			->orderBy('content')
			->get();
		return view('admin.chapter.index', [
			'$chapters' => $chapters
		]);
	}
}
