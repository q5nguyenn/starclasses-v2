<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table = 'tags';
	protected $fillable = [
		'name'
	];
	public $timestamps = false;
	use HasFactory;
	public function courses()
	{
		return $this->belongsToMany(Course::class);
	}
}
