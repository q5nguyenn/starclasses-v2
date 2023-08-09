<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Traits\Utilities;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
	use Utilities;
	function index(Request $request)
	{
		$list = Report::paginate(10);
		return view('admin.report.index', [
			'list' => $list
		]);
	}

	function update(Request $request)
	{
		$id = $request->id;
		$val = $request->input('val');
		$report = Report::find($id);
		$report->update(['status' => $val]);
	}

	function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$report = Report::find($request->id);
			if ($report) {
				$report->reportImages()->delete();
				$report->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Report not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete report because there are related somethings!'
			]);
		}
	}

	function search(Request $request)
	{
		$status = $request->status;
		$query = Report::where('type', 'like', '%' . $request->keyword . '%');
		if ($status != '') {
			$query->where('status', '=', $status);
		}
		$query->select('reports.*');
		$list = $query;
		$list = $list->get();
		return view('admin.report.index', [
			'list' => $list,
			'keyword' => $request->keyword,
			'status' => $status
		]);
	}
}
