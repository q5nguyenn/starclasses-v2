<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
	protected $table = 'sliders';
	protected $fillable = [
		'course_id',
		'thumbnail'
	];
	public $timestamps = false;
	// use SoftDeletes;
	use HasFactory;

	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
