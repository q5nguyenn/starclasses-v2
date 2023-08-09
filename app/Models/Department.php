<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
	protected $table = 'departments';
	protected $fillable = [
		'name',
		'faculty_id',
		'slug'
	];
	public $timestamps = false;
	protected $dates = ['deleted_at'];
	// use SoftDeletes;
	use HasFactory;
	public function courses()
	{
		return $this->hasMany(Course::class);
	}
	public function faculty()
	{
		return $this->belongsTo(Faculty::class);
	}
}
