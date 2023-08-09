<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationUser extends Model
{
	protected $table = 'notification_user';
	protected $fillable = [
		'notification_id',
		'user_id',
		'status'
	];
	// use SoftDeletes;
	use HasFactory;
	public function notificaton()
	{
		return $this->belongsTo(Notification::class, 'notification_id');
	}
}
