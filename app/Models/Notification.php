<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
	use HasFactory;
	// use SoftDeletes;
	protected $fillable = [
		'user_id',
		'title',
		'content'
	];
	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function notification_users()
	{
		return $this->hasMany(NotificationUser::class);
	}

	public function read()
	{
		$notice = NotificationUser::where('notification_id', $this->id)
			->where('user_id', Auth::id())->first();
		if (!empty($notice)) {
			if ($notice->status ==  1)
				return  true;
		}
		return false;
	}
}
