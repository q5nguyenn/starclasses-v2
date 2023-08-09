<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacultyRequest;
use App\Models\Faculty;
// use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\Utilities;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminFacultyController extends Controller
{
	use Utilities;
	public function index()
	{
		$list = Faculty::Paginate(10);
		return view('admin.faculty.index', [
			'list' => $list,
		]);
	}

	public function create(Request $request)
	{
		return view('admin.faculty.create');
	}

	public function store(FacultyRequest $request)
	{
		Faculty::create([
			'name' => $request->name,
			'icon' => $request->icon,
			'slug' => Str::slug($request->name, '-')
		]);
		return redirect()->route('admin.faculty.index');
	}

	public function edit(Request $request)
	{
		$faculty = Faculty::find($request->id);
		return view('admin.faculty.edit', ['faculty' => $faculty]);
	}

	public function update(FacultyRequest $request)
	{
		// dd($request->all());
		Faculty::where('id', $request->id)
			->update([
				'name' => $request->name,
				'icon' => $request->icon,
				'slug' => Str::slug($request->name, '-')
			]);
		return redirect()->route('admin.faculty.index');
	}

	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$faculty = Faculty::find($request->id);
			if ($faculty) {
				$faculty->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Faculty not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete faculty because there are related departments!'
			]);
		}
	}

	public function search(Request $request)
	{
		$list = Faculty::where('name', 'like', '%' . $request->keyword . '%');
		$list = $list->paginate(10);
		return view('admin.faculty.index', [
			'list' => $list,
			'keyword' => $request->keyword,
		]);
	}
}
