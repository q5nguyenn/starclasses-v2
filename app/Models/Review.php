<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
	protected $table = 'reviews';
	protected $fillable = [
		'content',
		'rate',
		'status',
		'course_id',
		'user_id'
	];
	// use SoftDeletes;
	use HasFactory;
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
