<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillCourse;
use App\Models\Cart;
use App\Models\Combo;
use App\Models\Course;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Utilities;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$user = Auth::user();
		$carts = $user->carts;
		if (count($carts) == 0) {
			return redirect()->route('profile', ['slug' => 'order-history']);
		}
		return view('checkout', [
			'carts' => $carts
		]);
	}

	public function payment(Request $request)
	{
		$user = Auth::user();
		$carts = $user->carts;
		$courses = $carts->map(function ($cart) {
			return $cart->course;
		});
		//Bill
		$bill = Bill::create([
			'user_id' => (int)$user->id
		]);
		$bill->courses()->attach($courses);
		// Progress
		foreach ($courses as $course) {
			foreach ($course->chapters as $chapter) {
				if ($chapter->parent_id != 0)
					Progress::create([
						'user_id' => $user->id,
						'chapter_id' => $chapter->id,
						'complete' => false
					]);
			}
		}
		$carts->each->delete();
		//Gửi thông báo
		$htmlContent = '';
		foreach ($courses as $index => $course) {
			if ($index == 0) {
				$htmlContent .= '<p>Course Name: <strong>' . $course->name . '</strong></p>
				<p>Instructor: <strong>' . $course->user->name . '</strong></p>';
			} else {
				$htmlContent .= '<hr><p>Course Name: <strong>' . $course->name . '</strong></p>
				<p>Instructor: <strong>' . $course->user->name . '</strong></p>';
			}
		}
		$content = '<p id="isPasted">Hi <strong>' . $user->name . '</strong>,</p>
								<p>We are pleased to announce that you have successfully purchased the course on our website. 
								This is an important step in enhancing your knowledge and skills, and we are delighted to accompany you on your learning journey.
								</p>
								<p>Below is information regarding the courses you have purchased:</p>
								' . $htmlContent . '
								<hr>
								
								<p>Your course has been activated. You can now access the course right on our website.</p>
								<p>If you have any problems or have questions, don&#39;t hesitate to contact us. We are always happy to assist you.</p>
								<p>Wishing you a great learning experience and success on this journey!</p>
								<p>Best regards, <strong>Admin q5nguyenn</strong></p>';
		$this->sendNotification($user, '🎉Successfully activated the successful course🎉', $content);
	}

	public function indexNow(Request $request)
	{
		$slug = $request->slug;
		$course = Course::where('slug', $slug)->first();
		if (!$course) {
			abort(404);
		}
		return view('checkout-now', [
			'course' => $course
		]);
	}

	public function paymentNow(Request $request)
	{
		$course_id = $request->input('course_id');
		$user = Auth::user();
		$course  = Course::find($course_id);
		$cart = Cart::where('user_id', $user->id)
			->where('course_id', $course_id)->first();
		if (!empty($cart)) {
			$cart->delete();
		}
		$bill = Bill::create([
			'user_id' => (int)$user->id
		]);
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
		//Gửi thông báo
		$this->sendNotification(
			$user,
			'🎉Successfully activated the successful course🎉',
			$course->getNotificationContent()
		);
	}

	function new(Request $request)
	{
		try {
			DB::beginTransaction();
			$billCourse = BillCourse::orderByDesc('created_at')
				->take(20)->get()->random();
			DB::commit();
			return response()->json([
				'user_name' => $billCourse->bill->user->name,
				'user_thumbnail' => $billCourse->bill->user->thumbnail,
				'course_slug' =>  $billCourse->course->slug,
				'course_name' => $billCourse->course->name,
				'teacher_name' => $billCourse->course->user->name,
			]);
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'No data!'
			]);
		}
	}


	public function indexComboNow(Request $request)
	{
		$slug = $request->slug;
		$combo = Combo::where('slug', $slug)->first();
		if (!$combo) {
			abort(404);
		}
		return view('checkout-combo-now', [
			'combo' => $combo,
			'courses' => $combo->courses,

		]);
	}


	public function paymentComboNow(Request $request)
	{
		$combo_id = $request->input('combo_id');
		$user = Auth::user();
		$combo  = Combo::find($combo_id);
		$courses = $combo->courses;
		$coursesToRemove = [];
		foreach ($combo->courses as $course) {
			// Kiểm tra cart nếu có thì xoá trong giỏ hàng
			$cart = Cart::where('user_id', $user->id)
				->where('course_id', $course->id)->first();
			if (!empty($cart)) {
				$cart->delete();
			}

			// Kiểm tra nếu mua rồi thì không thêm chi tiết hoá đơn nữa
			$bill = Bill::join('bill_course', 'bills.id', '=', 'bill_course.bill_id')
				->where('user_id', $user->id)
				->where('course_id', $course->id)
				->select('bill_course.*')
				->first();

			if ($bill) {
				$coursesToRemove[] = $course->id;
			}
		}

		$courses = $courses->whereNotIn('id', $coursesToRemove);

		$bill = Bill::create([
			'user_id' => (int)$user->id
		]);

		$bill->courses()->attach($courses);

		// Progress
		foreach ($courses as $course) {
			foreach ($course->chapters as $chapter) {
				if ($chapter->parent_id != 0)
					Progress::create([
						'user_id' => $user->id,
						'chapter_id' => $chapter->id,
						'complete' => false
					]);
			}
		}
		//Gửi thông báo
		$htmlContent = '';
		foreach ($courses as $index => $course) {
			if ($index == 0) {
				$htmlContent .= '<p>Course Name: <strong>' . $course->name . '</strong></p>
				<p>Instructor: <strong>' . $course->user->name . '</strong></p>';
			} else {
				$htmlContent .= '<hr><p>Course Name: <strong>' . $course->name . '</strong></p>
				<p>Instructor: <strong>' . $course->user->name . '</strong></p>';
			}
		}
		$content = '<p id="isPasted">Hi <strong>' . $user->name . '</strong>,</p>
								<p>We are pleased to announce that you have successfully purchased the course on our website. 
								This is an important step in enhancing your knowledge and skills, and we are delighted to accompany you on your learning journey.
								</p>
								<p>Below is information regarding the courses you have purchased:</p>
								' . $htmlContent . '
								<hr>
								
								<p>Your course has been activated. You can now access the course right on our website.</p>
								<p>If you have any problems or have questions, don&#39;t hesitate to contact us. We are always happy to assist you.</p>
								<p>Wishing you a great learning experience and success on this journey!</p>
								<p>Best regards, <strong>Admin q5nguyenn</strong></p>';
		$this->sendNotification($user, '🎉Successfully activated the successful course🎉', $content);
	}
}
