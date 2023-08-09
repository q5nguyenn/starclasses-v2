<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Tag;
use App\Models\User;
use App\Traits\StoreImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\Utilities;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Str;

class AdminCourseController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$list = Course::Paginate(10);
		$user = Auth::user();
		if ($user->isVip()) {
			$list = Course::Paginate(10);
		} else {
			$list = Course::where('teacher_id', $user->id)->paginate(10);
		}
		$listTeachers = User::all();
		$listDepartments = Department::all();
		$listFaculties = Faculty::all();
		return view('admin.course.index', [
			'list' => $list,
			'listTeachers' => $listTeachers,
			'listDepartments' => $listDepartments,
			'listFaculties' => $listFaculties
		]);
	}
	public function create(Request $request)
	{
		$listDepartments = Department::all();
		$listTeachers = User::all();
		$listTags = Tag::all();
		return view('admin.course.create', [
			'listDepartments' => $listDepartments,
			'listTeachers' => $listTeachers,
			'listTags' => $listTags
		]);
	}
	public function store(CourseRequest $request)
	{
		$url = $this->storeUpload($request, 'thumbnail', 'thumbnails');
		if (empty($url)) {
			$url = "/images/slide-default.jpg";
		}
		$courseData = [
			'name' => $request->name,
			'description' => $request->description,
			'price' => $request->price,
			'discount' => $request->discount,
			'thumbnail' => $url,
			'department_id' => $request->department_id,
			'teacher_id' => Auth::id(),
			'learn' => $request->learn,
			'introduction' => $request->introduction
		];
		$tags = $request->tags;
		$course = Course::create($courseData);
		$course->update([
			'slug' => Str::slug($course->name, '-') . '-' . $course->id,
		]);
		$course->tags()->attach($tags);
		return redirect()->route('admin.course.index');
	}
	public function edit(Request $request)
	{
		$listDepartments = Department::all();
		$listTeachers = User::all();
		$listTags = Tag::all();
		$tagIds = Arr::pluck(Course::find($request->id)->tags, 'id');
		$course = Course::find($request->id);
		return view('admin.course.edit', [
			'course' => $course,
			'listDepartments' => $listDepartments,
			'listTeachers' => $listTeachers,
			'listTags' => $listTags,
			'tagIds' => $tagIds
		]);
	}
	public function update(CourseRequest $request)
	{
		$course = Course::find($request->id);
		$url = $this->storeUpload($request, 'thumbnail', 'thumbnails');
		if (empty($url)) {
			$url = $course->thumbnail;
		} else {
			$this->deleteFile($course->thumbnail);
		}
		$courseData = [
			'name' => $request->name,
			'description' => $request->description,
			'price' => $request->price,
			'discount' => $request->discount,
			'thumbnail' => $url,
			'department_id' => $request->department_id,
			'learn' => $request->learn,
			'introduction' => $request->introduction,
		];
		// dd($courseData);
		$course->update($courseData);
		$course->update([
			'slug' => Str::slug($course->name, '-') . '-' . $course->id,
		]);
		$course = Course::find($request->id);
		$tags = $request->tags;
		$course->tags()->sync($tags);
		return redirect()->route('admin.course.index');
		// $path = $request->file('thumbnail')->store('public/thumbnails');
		// return $path;
	}
	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$course = Course::find($request->id);
			if ($course) {
				$thumbnail = $course->thumbnail;
				$tags = $course->tags;
				$course->tags()->detach($tags);
				$course->delete();
				$this->deleteFile($thumbnail);
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Course not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete course because there are related somethings!'
			]);
		}
	}

	public function search(Request $request)
	{
		$user = Auth::user();
		$faculty_id = $request->faculty_id;
		$department_id = $request->department_id;
		$listDepartments = Department::all();
		$query = Course::join('users', 'users.id', '=', 'courses.teacher_id')
			->join('departments', 'departments.id', '=', 'courses.department_id')
			->where(function ($query) use ($request) {
				$query->where('users.name', 'like', '%' . $request->keyword . '%')
					->orwhere('courses.name', 'like', '%' . $request->keyword . '%');
			});
		$query->select('courses.*');
		if (!empty($faculty_id)) {
			$listDepartments = Faculty::find($faculty_id)->departments;
			$query->where('departments.faculty_id', '=', $faculty_id);
		}
		if (!empty($department_id)) {
			$query->where('departments.id', '=', $department_id);
		}
		$list = $query;
		$count = $this->numberDisplay(count($list->get()));
		if ($user->isVip()) {
			$list = $list->paginate(10);;
		} else {
			$list = $list->where('teacher_id', $user->id)->paginate(10);
		}
		$listTeachers = User::all();

		$listFaculties = Faculty::all();
		return view('admin.course.index', [
			'list' => $list,
			'listTeachers' => $listTeachers,
			'listDepartments' => $listDepartments,
			'count' => $count,
			'keyword' => $request->keyword,
			'listFaculties' => $listFaculties,
			'faculty_id' => $faculty_id,
			'department_id' => $department_id,
		]);
	}
}
