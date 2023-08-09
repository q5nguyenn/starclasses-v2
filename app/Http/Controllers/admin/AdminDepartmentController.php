<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Traits\Utilities;
use Illuminate\Support\Facades\DB;

class AdminDepartmentController extends Controller
{
	use Utilities;
	public function index()
	{
		$list = Department::Paginate(10);
		$listFaculties = Faculty::all();
		return view('admin.department.index', [
			'list' => $list,
			'listFaculties' => $listFaculties,
		]);
	}

	public function create(Request $request)
	{
		$listFaculties = Faculty::all();
		return view('admin.department.create', ['listFaculties' => $listFaculties]);
	}

	public function store(DepartmentRequest $request)
	{
		Department::create([
			'name' => $request->name,
			'faculty_id' => $request->faculty_id,
			'slug' => Str::slug($request->name, '-')
		]);
		return redirect()->route('admin.department.index');
	}

	public function edit(Request $request)
	{
		$listFaculties = Faculty::all();
		$department = Department::find($request->id);
		return view('admin.department.edit', ['department' => $department, 'listFaculties' => $listFaculties]);
	}

	public function update(DepartmentRequest $request)
	{
		Department::where('id', $request->id)
			->update([
				'name' => $request->name,
				'faculty_id' => $request->faculty_id,
				'slug' => Str::slug($request->name, '-')
			]);
		return redirect()->route('admin.department.index');
	}

	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$department = Department::where('id', $request->id);
			if ($department) {
				$department->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Department not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete department because there are related courses!'
			]);
		}
	}

	public function search(Request $request)
	{
		$faculty_id = $request->faculty_id;
		$query = Department::where('departments.name', 'like', '%' . $request->keyword . '%');
		if (!empty($faculty_id)) {
			$query->where('departments.faculty_id', '=', $faculty_id);
		}
		$list = $query;
		$count = $this->numberDisplay(count($list->get()));
		$list = $list->paginate(10);
		$listFaculties = Faculty::all();
		return view('admin.department.index', [
			'list' => $list,
			'listFaculties' => $listFaculties,
			'count' => $count,
			'keyword' => $request->keyword,
			'faculty_id' => $faculty_id
		]);
	}
}
