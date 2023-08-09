<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
	protected  $table = 'wishlists';
	protected $fillable = [
		'user_id',
		'course_id'
	];
	use HasFactory;
	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
