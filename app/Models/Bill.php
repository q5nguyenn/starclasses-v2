<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
	protected $table = 'bills';
	protected $fillable = [
		'user_id'
	];
	// use SoftDeletes;
	use HasFactory;
	public function courses()
	{
		return $this->belongsToMany(Course::class)->withTimestamps();
	}
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function totalDiscount()
	{
		$total_discount = 0;
		$courses = $this->courses;
		foreach ($courses as $course) {
			$total_discount += $course->discount;
		}
		return $total_discount;
	}

	public function totalPrice()
	{
		$total_price = 0;
		$courses = $this->courses;
		foreach ($courses as $course) {
			$total_price += $course->price;
		}
		return $total_price;
	}
}
