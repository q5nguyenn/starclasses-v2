<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Models\ReportImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Utilities;

class ReportController extends Controller
{
	use Utilities;
	function report(ReportRequest $request)
	{
		$user = Auth::user();
		$url01 = $this->storeUpload($request, 'image-report01', 'reports');
		$url02 = $this->storeUpload($request, 'image-report02', 'reports');
		$url03 = $this->storeUpload($request, 'image-report03', 'reports');
		$report = Report::create([
			'type' => $request->type,
			'description' => $request->description,
			'status' => 'uncheck',
			'user_id' => Auth::id()
		]);
		if (!empty($url01)) {
			ReportImage::create([
				'thumbnail' => $url01,
				'report_id' => $report->id
			]);
		}
		if (!empty($url02)) {
			ReportImage::create([
				'thumbnail' => $url02,
				'report_id' => $report->id
			]);
		}
		if (!empty($url03)) {
			ReportImage::create([
				'thumbnail' => $url03,
				'report_id' => $report->id
			]);
		}
		//Gửi thông báo
		$content = '<p id="isPasted">Your reportID: #<strong>' . $report->id . '</strong>,</p>
								<p>Your support request has been sent to us. We will fix it as soon as possible.
								An email will be sent to you when the request is processed.
								</p>
								<p><strong>Thank you very much!</strong></p>';
		$this->sendNotification($user, '💖Thank you for submitting your report💖', $content);
		return back()->with('popup_report', true);
	}
}
