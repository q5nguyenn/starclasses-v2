<?php

namespace App\Traits;

use App\Models\Notification;
use Illuminate\Support\Facades\Storage;

trait Utilities
{
	//CleanURL
	public function cleanURL($url)
	{
		$cleanUrl = str_replace('/storage/', '', $url);
		return  $cleanUrl;
	}

	//StoreUpLoad
	public function storeUpload($request, $fieldName, $folderName)
	{
		if ($request->hasFile($fieldName)) {
			$file = $request->file($fieldName);
			$path = $file->store('public/' . $folderName);
			$url = Storage::url($path);
			return $url;
		}
		return null;
	}

	//Delete file by link public
	public function deleteFile($thumnail)
	{
		$cleanUrl = str_replace('/storage/', '', $thumnail);
		Storage::disk('public')->delete($cleanUrl);
	}

	//Display number
	public function numberDisplay($num)
	{
		if (0 < $num && $num < 10) {
			return '0' . $num;
		} else {
			return $num;
		}
	}

	//Sortby
	public function sortBy($query, $sort_by, $star)
	{
		$query->leftJoin('users', 'users.id', '=', 'courses.teacher_id')
			->selectRaw('courses.*, users.name as teacher_name');
		$query->leftJoin('bill_course', 'courses.id', '=', 'bill_course.course_id')
			->selectRaw('courses.*, count(*) as students')
			->groupBy('courses.id');
		$query->leftJoin('reviews', 'courses.id', '=', 'reviews.course_id')
			->selectRaw('courses.*, AVG(rate) as star, count(*) as number_reviews')
			->groupBy('courses.id');
		if ($sort_by == 'most-student') {
			$query->orderBy('students', 'desc');
		} else if ($sort_by == 'most-star') {
			$query->orderBy('star', 'desc');
		} else if ($sort_by == 'newest') {
			$query->orderBy('updated_at', 'desc');
		} else if ($sort_by == 'price-desc') {
			$query->orderBy('discount', 'desc');
		} else if ($sort_by == 'price-asc') {
			$query->orderBy('discount');
		};
		if ($sort_by != 'most-star') {
			if (!empty($star)) {
				$query->having('star', '>=', $star)
					->orderBy('star', 'desc');
			};
		} else {
			if (!empty($star)) {
				$query->having('star', '>=', $star);
			};
		}
		return $query;
	}

	function sendNotification($toUser, $title,  $content)
	{
		$notification = Notification::create([
			'user_id' => 2,
			'title' => $title,
			'content' => $content
		]);
		$notification->users()->attach($toUser);
	}
}
