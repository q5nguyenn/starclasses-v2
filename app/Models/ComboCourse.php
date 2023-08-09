<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboCourse extends Model
{
	use HasFactory;
	protected $fillable = [
		'combo_id',
		'course_id',
	];
}
