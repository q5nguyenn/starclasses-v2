<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CodeRequest;
use App\Models\Code;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminCodeController extends Controller
{
	function index(Request $request)
	{
		$list = Code::Paginate(10);
		$listCourses = Course::all();
		return view('admin.code.index', [
			'list' => $list,
			'listCourses' => $listCourses,
		]);
	}
	public function create(Request $request)
	{
		$listCourses = Course::all();
		return view('admin.code.create', ['listCourses' => $listCourses,]);
	}

	public function store(CodeRequest $request)
	{
		Code::create([
			'name' => $request->name,
			'course_id' => $request->course_id,
			'time' => $request->time
		]);
		return redirect()->route('admin.code.index');
	}

	public function edit(Request $request)
	{
		$listCourses = Course::all();
		$code = Code::find($request->id);
		return view('admin.code.edit', ['listCourses' => $listCourses, 'code' => $code]);
	}

	public function update(CodeRequest $request)
	{
		Code::where('id', $request->id)
			->update([
				'name' => $request->name,
				'course_id' => $request->course_id,
				'time' => $request->time
			]);
		return redirect()->route('admin.code.index');
	}

	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$code = Code::where('id', $request->id);
			if ($code) {
				$code->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Code not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete code because there are related somethings!'
			]);
		}
	}

	public function search(Request $request)
	{
		$query = Code::select('codes.*')
			->join('courses', 'codes.course_id', '=', 'courses.id')
			->where('codes.name', 'like', '%' . $request->keyword . '%')
			->orWhere('courses.name', 'like', '%' . $request->keyword . '%');
		$list = $query;
		$list = $list->paginate(10);
		$listCourses = Course::all();
		return view('admin.code.index', [
			'list' => $list,
			'listCourses' => $listCourses,
			'keyword' => $request->keyword,
		]);
	}
}
