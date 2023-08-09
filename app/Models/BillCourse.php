<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillCourse extends Model
{
	protected $table = 'bill_course';
	protected $fillable = [
		'bill_id',
		'course_id'
	];
	use HasFactory;

	public function course()
	{
		return $this->belongsTo(Course::class);
	}
	public function bill()
	{
		return $this->belongsTo(Bill::class);
	}
}
