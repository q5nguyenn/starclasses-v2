<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Models\Course;
use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminBillController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$list = Bill::Paginate(10);
		$count = $this->numberDisplay(count(Bill::get()));
		return view('admin.bill.index', [
			'list' => $list,
			'count' => $count
		]);
	}
	public function create(Request $request)
	{
		$users = User::all();
		$courses = Course::all();
		return view('admin.bill.create', [
			'users' => $users,
			'courses' => $courses
		]);
	}
	public function store(BillRequest $request)
	{
		$bill = Bill::create([
			'user_id' => $request->user_id,
		]);
		$bill->courses()->attach($request->courses);
		return redirect()->route('admin.bill.index');
	}
	public function edit(Request $request)
	{
		$bill = Bill::find($request->id);
		$users = User::all();
		$courses = Course::all();
		return view('admin.bill.edit', [
			'bill' => $bill,
			'users' => $users,
			'courses' => $courses
		]);
	}
	public function update(BillRequest $request)
	{
		$bill = Bill::find($request->id);
		$bill->update([
			'user_id' => $request->user_id,
		]);
		$bill->courses()->sync($request->courses);
		return redirect()->route('admin.bill.index');
	}

	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$bill = Bill::find($request->id);
			if ($bill) {
				$bill->courses()->detach();
				$bill->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Bill not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete bill because there are related somethings!'
			]);
		}
	}

	public function search(Request $request)
	{
		$sort_by = $request->sort_by;
		$query = Bill::join('users', 'users.id', '=', 'bills.user_id')
			->where('email', 'like', '%' . $request->keyword . '%')
			->orWhereRaw("DATE_FORMAT(bills.created_at, '%d-%m-%Y') LIKE ?", ['%' . $request->keyword . '%'])
			->select('bills.*', 'users.name');
		if (!empty($sort_by)) {
			if ($sort_by == 'newest') {
				$query->orderBy('bills.created_at', 'desc');
			} else {
				$query->orderBy('bills.created_at', 'asc');
			}
		}
		$list = $query;
		$count = $this->numberDisplay(count($list->get()));
		$list = $list->paginate(10);
		return view('admin.bill.index', [
			'list' => $list,
			'count' => $count,
			'keyword' => $request->keyword,
			'sort_by' => $sort_by
		]);
	}
}
