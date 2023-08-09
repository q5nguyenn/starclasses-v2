<?php

namespace App\Models;

use App\Models\Chapter as ModelsChapter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Chapter extends Model
{
	// use SoftDeletes;
	use HasFactory;
	protected $fillable = [
		'content',
		'parent_id',
		'video_link',
		'course_id',
	];
	public function chapterChilds()
	{
		return $this->hasMany(ModelsChapter::class, 'parent_id');
	}
	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	function completed()
	{
		$user_id = Auth::id();
		$progress = Progress::where('progress.chapter_id', $this->id)
			->where('progress.user_id', $user_id)->first();
		if ($progress) {
			if ($progress->completed == 1) return true;
		}
		return false;
	}
}
