<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
	use HasFactory;
	protected $fillable = [
		'name',
		'problem_solving',
		'introduce',
		'price',
		'expiration_date',
		'slug'
	];

	public function courses()
	{
		return $this->belongsToMany(Course::class);
	}

	function primaryPrice()
	{
		$primaryPrice = 0;
		foreach ($this->courses as $course) {
			$primaryPrice += $course->price;
		}
		return $primaryPrice;
	}

	function discountPercent()
	{
		$primaryPrice = $this->primaryPrice();
		$discountPercent = round(($primaryPrice - $this->price) / $primaryPrice * 100);
		return $discountPercent;
	}

	function allChapters()
	{
		$courses = $this->courses;
		$count = 0;
		foreach ($courses as $course) {
			$count += $course->allChapters();
		}
		return $count;
	}
}
