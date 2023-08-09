<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillCourse;
use App\Models\Cart;
use App\Models\Code;
use App\Models\Course;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Utilities;

class CodeController extends Controller
{
	use Utilities;
	function active(Request $request)
	{
		$name = $request->name;
		$user = Auth::user();
		$code = Code::where('name', $name)->first();
		if ($code) {
			$bill = BillCourse::join('bills', 'bills.id', '=', 'bill_course.bill_id')
				->where('bill_course.course_id', $code->course_id)
				->where('bills.user_id', $user->id)->first();
			if ($bill) {
				return response()->json([
					'message' => 'You have already purchased this course.',
					'data' => null,
					'icon' => '<i class="bi bi-x-lg voucher-wrong"></i>'
				]);
			} else {
				if ($code->time > 0) {
					$course_id = $code->course_id;
					$course  = Course::find($course_id);
					$cart = Cart::where('user_id', $user->id)
						->where('course_id', $course_id)->first();
					if (!empty($cart)) {
						$cart->delete();
					}
					$bill = Bill::create([
						'user_id' => (int)$user->id
					]);
					//Gửi thông báo
					$this->sendNotification(
						$user,
						'🎉Successfully activated the successful course🎉',
						$course->getNotificationContent()
					);
					// Progress
					foreach ($course->chapters as $chapter) {
						if ($chapter->parent_id != 0)
							Progress::create([
								'user_id' => $user->id,
								'chapter_id' => $chapter->id,
								'complete' => false
							]);
					}
					$bill->courses()->attach($course);
					$code->update([
						'time' => $code->time - 1
					]);
					return response()->json([
						'message' => 'You have successfully activated.',
						'data' => $course,
						'icon' => '<i class="bi bi-check-lg"></i>'
					]);
				} else {
					return response()->json([
						'message' => 'The discount code has expired.',
						'data' => null,
						'icon' => '<i class="bi bi-x-lg voucher-wrong"></i>'
					]);
				}
			}
		}
		return response()->json([
			'message' => 'Voucher code does not exist.',
			'data' => null,
			'icon' => '<i class="bi bi-x-lg voucher-wrong"></i>'
		]);
	}
}
