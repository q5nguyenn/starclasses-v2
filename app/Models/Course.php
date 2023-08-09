<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
	protected $table = 'courses';
	protected $fillable = [
		'name',
		'description',
		'price',
		'discount',
		'thumbnail',
		'department_id',
		'teacher_id',
		'learn',
		'introduction',
		'slug',
	];
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	// use SoftDeletes;
	use HasFactory;
	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}
	public function user()
	{
		return $this->belongsTo(User::class, 'teacher_id');
	}
	public function department()
	{
		return $this->belongsTo(Department::class);
	}
	public function bills()
	{
		return $this->belongsToMany(Bill::class);
	}
	public function chapters()
	{
		return $this->hasMany(Chapter::class);
	}

	public function discountPercent()
	{
		return round(($this->price - $this->discount) / $this->price * 100);
	}
	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function combos()
	{
		return $this->belongsToMany(Combo::class);
	}


	public function byRate()
	{
		$totalRate = 0;
		$numberReviews = 0;
		foreach ($this->reviews as $review) {
			$numberReviews++;
			$totalRate += $review->rate;
		}
		if ($numberReviews == 0) {
			return 0;
		}
		return round($totalRate / $numberReviews, 1);
	}

	function getTemplStar($rate)
	{
		$rate = round($rate * 2) / 2;
		$rateInteger = floor($rate);
		$rateFloat = $rate - $rateInteger;
		$htmlRate = '';
		for ($i = 1; $i <= $rateInteger; $i++) {
			$htmlRate .= '<i class="bi bi-star-fill"></i>';
		}
		if ($rateFloat == 0.5) {
			$htmlRate .= '<i class="bi bi-star-half"></i>';
			for ($i = $rateInteger + 2; $i <= 5; $i++) {
				$htmlRate .= '<i class="bi bi-star"></i>';
			}
		} else {
			for ($i = $rateInteger + 1; $i <= 5; $i++) {
				$htmlRate .= '<i class="bi bi-star"></i>';
			}
		}
		return $htmlRate;
	}

	function completedChapter($user_id)
	{
		$chapters = Progress::join('chapters', 'progress.chapter_id', '=', 'chapters.id')
			->join('courses', 'courses.id', '=', 'chapters.course_id')
			->where('courses.id', $this->id)
			->where('user_id', $user_id)
			->where('completed', true)
			->get();
		return count($chapters);
	}

	function allChapters()
	{
		$count = 0;
		foreach ($this->chapters as $chapter) {
			if ($chapter->parent_id != 0) $count++;
		}
		return $count;
	}

	function getNotificationContent()
	{
		return '<p id="isPasted">Hi <strong>' . $this->name . '</strong>,</p>
		<p>We are pleased to announce that you have successfully purchased the course on our website. 
		This is an important step in enhancing your knowledge and skills, and we are delighted to accompany you on your learning journey.
		</p>
		<p>Below is information regarding the course you have purchased:</p>
		<p>Course Name: <strong>' . $this->name . '</strong></p>
		<p>Instructor: <strong>' . $this->user->name . '</strong></p>
		<p>Your course has been activated. You can now access the course right on our website.</p>
		<p>If you have any problems or have questions, don&#39;t hesitate to contact us. We are always happy to assist you.</p>
		<p>Wishing you a great learning experience and success on this journey!</p>
		<p>Best regards, <strong>Admin q5nguyenn</strong></p>';
	}
}
