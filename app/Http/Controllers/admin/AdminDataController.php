<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Province;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminDataController extends Controller
{
	public function insertTeacher(Request $request)
	{
		dd("Success");
		$client = new Client();
		$response = $client->request('GET', 'https://provinces.open-api.vn/api/?depth=3');
		$provinces = json_decode($response->getBody(), true);
		$json = File::get('data\courses.json');
		$students = json_decode($json, true);
		foreach ($students as $student) {
			$name =  	$student['teacher'];
			$description = Str::limit($student['desc'], 200);
			$email =  str_replace(' ', '', strtolower($name)) . "@gmail.com";
			// $date = date("Y-m-d", '1998-02-26');
			$year = rand(1990, 2000);
			$month = rand(1, 12);
			$day = rand(1, 28);
			$date = date($year . '-' . $month . '-' . $day);
			$phone_number = '0' . mt_rand(100000000, 999999999);
			$int = rand(0, 62);
			$address = $provinces[$int]['name'];
			$role = [3];
			$file = $student['teacher_avatar']; // Đường dẫn tệp tin ảnh
			$filePath = Storage::putFile('public/thumbnails', $file);
			// Lấy URL công khai của file đã upload
			$url = Storage::url($filePath);
			if (User::all()->contains('email', $email)) {
				continue;
			} else {
				$user = User::create([
					'thumbnail' => $url,
					'description' => $description,
					'name' => $name,
					'email' => $email,
					'password' => bcrypt('123456'),
					'birth_day' => $date,
					'phone_number' => $phone_number,
					'address' => $address,
				]);
				$user->roles()->attach($role);
			}
		}
	}

	//Cập nhật tỉnh thành
	public function updateTeacher(Request $request)
	{
		dd("Update successfull");
		$users = User::all();
		$provinces = Province::all();
		$provinceIds = $provinces->pluck('id')->toArray();
		foreach ($users as $item) {
			$randomProvinceId = $provinceIds[array_rand($provinceIds)];
			$item->update([
				'province_id' => $randomProvinceId
			]);
		}
	}

	public function insertCourse(Request $request)
	{
		dd("Success");
		$json = File::get('data\courses.json');
		$courses = json_decode($json, true);
		foreach ($courses as $course) {
			$name =  	$course['name'];
			$description = $course['desc'];
			$file = $course['cover'];
			$filePath = Storage::putFile('public/thumbnails', $file);
			$url = Storage::url($filePath);
			$price = $course['price_old'];
			$discount = $course['price_sale'];
			$department_id = -1;
			$teacher_id = -1;
			foreach (Department::all() as $department) {
				if ($department->name == $course['subject']) {
					$department_id = $department->id;
					break;
				}
			}
			foreach (User::all() as $user) {
				if ($user->name == $course['teacher']) {
					$teacher_id = $user->id;
				}
			}
			$new_course = Course::create([
				'name' => $name,
				'description' => $description,
				'thumbnail' => $url,
				'price' => $price,
				'discount' => $discount,
				'department_id' => $department_id,
				'teacher_id' => $teacher_id,
			]);
		}
	}

	public function insertChapter(Request $request)
	{
		$courses = Course::all();
		foreach ($courses as $index => $course) {
			Chapter::create([
				'content' => 'Part 1: Introduction to the course',
				'parent_id' => 0,
				'course_id' => $course->id
			]);
			Chapter::create([
				'content' => 'Lesson 1: Introduction, things to prepare',
				'parent_id' => $index * 18 + 1,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 2: Exercises to train memory',
				'parent_id' => $index * 18 + 1,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 3: Memorization techniques',
				'parent_id' => $index * 18 + 1,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 4: Memory anchoring method - image encoding',
				'parent_id' => $index * 18 + 1,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Part 2: Applying reflection to life',
				'parent_id' => 0,
				'course_id' => $course->id
			]);
			Chapter::create([
				'content' => "Lesson 5: Remember good books you've read",
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 6: Remember all the tasks that you have to do in a day',
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => "Lesson 7: Remember the journey you've been through",
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 8: Remember the name and characteristics of the Customer or anyone',
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 9: Remember phone number, date of birth, position, hobby... customers',
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 10: Remembering things in the house - things you often forget (keys, wallets, ...)',
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 11: Memorize for Presentation without looking at the paper',
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 12: Memorize the date',
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 13: Practice memorization',
				'parent_id' => $index * 18 + 6,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Part 3: Application to learning',
				'parent_id' => 0,
				'course_id' => $course->id
			]);
			Chapter::create([
				'content' => 'Lesson 14: Memorize the subjects Socio Literature - Geography - History',
				'parent_id' => $index * 18 + 16,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
			Chapter::create([
				'content' => 'Lesson 15: Memorize Nature Mathematics, Physics, Chemistry',
				'parent_id' => $index * 18 + 16,
				'course_id' => $course->id,
				'video_link' => 'https://www.youtube.com/embed/jfKfPfyJRdk'
			]);
		}
	}

	public function updateSlug(Request $request)
	{
		dd('Update slug successfull!');
		$faculties = Faculty::all();
		foreach ($faculties as $faculty) {
			$slug = Str::slug($faculty->name, '-');
			$faculty->update(['slug' => $slug]);
		}
		$departments = Department::all();
		foreach ($departments as $department) {
			$slug = Str::slug($department->name, '-');
			$department->update(['slug' => $slug]);
		}
		$courses = Course::all();
		foreach ($courses as $course) {
			$slug = Str::slug($course->name, '-') . '-' . $course->id;
			$course->update(['slug' => $slug]);
		}
		$users = User::all();
		foreach ($users as $user) {
			$slug = Str::slug($user->name, '-') . '-' . $user->id;
			$user->update(['slug' => $slug]);
		}
	}

	public function insertProvince(Request $request)
	{
		$client = new Client();
		$response = $client->request('GET', 'https://provinces.open-api.vn/api/?depth=3');
		$provinces = json_decode($response->getBody(), true);
		foreach ($provinces as $provinces) {
			$id = $provinces['code'];
			$name =  $provinces['name'];
			$codename = $provinces['codename'];
			$division_type = $provinces['division_type'];
			$phone_code = $provinces['phone_code'];
			Province::create([
				'id' => $id,
				'name' => $name,
				'codename' => $codename,
				'division_type' => $division_type,
				'phone_code' => $phone_code
			]);
		}
	}
}
