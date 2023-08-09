<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
	protected $table = 'faculties';
	protected $fillable = [
		'name',
		'icon',
		'slug'
	];
	public $timestamps = false;
	protected $dates = ['deleted_at'];
	// use SoftDeletes;
	use HasFactory;
	public function departments()
	{
		return $this->hasMany(Department::class);
	}

	// Đếm số lượng khoá học
	public function courses()
	{
		$courses =  Course::join('departments', 'courses.department_id', '=', 'departments.id')
			->join('faculties', 'departments.faculty_id', '=', 'faculties.id')
			->where('faculties.id', $this->id)
			->select('courses.*');
		return $courses;
	}
}
