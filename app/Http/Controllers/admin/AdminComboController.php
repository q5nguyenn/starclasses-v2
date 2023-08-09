<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComboRequest;
use App\Models\Combo;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminComboController extends Controller
{
	function index(Request $request)
	{
		$list = Combo::Paginate(10);
		return view('admin.combo.index', [
			'list' => $list,
		]);
	}
	function create(Request $request)
	{
		$courses = Course::all();
		return view('admin.combo.create', [
			'courses' => $courses
		]);
	}
	function store(ComboRequest $request)
	{
		$combo = Combo::create([
			'name' => $request->name,
			'problem_solving' => $request->problem_solving,
			'introduce' => $request->introduce,
			'price' => $request->price,
			'expiration_date' => $request->expiration_date,
		]);
		$combo->update([
			'slug' => Str::slug($combo->name, '-'),
		]);
		$combo->courses()->attach($request->courses);
		return redirect()->route('admin.combo.index');
	}
	function edit(Request $request)
	{
		$combo = Combo::find($request->id);
		$courses = Course::all();
		return view('admin.combo.edit', [
			'combo' => $combo,
			'courses' => $courses
		]);
	}
	function update(ComboRequest $request)
	{
		$combo = Combo::find($request->id);
		$combo->update([
			'name' => $request->name,
			'problem_solving' => $request->problem_solving,
			'introduce' => $request->introduce,
			'price' => $request->price,
			'expiration_date' => $request->expiration_date,
		]);
		$combo->update([
			'slug' => Str::slug($combo->name, '-'),
		]);
		$combo->courses()->sync($request->courses);
		return redirect()->route('admin.combo.index');
	}
	function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$combo = Combo::find($request->id);
			if ($combo) {
				$combo->courses()->detach();
				$combo->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Combo not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete combo because there are related somethings!'
			]);
		}
	}
	function search(Request $request)
	{
	}
}
