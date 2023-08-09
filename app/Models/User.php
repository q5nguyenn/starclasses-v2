<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'google_id',
		'password',
		'thumbnail',
		'description',
		'birth_day',
		'phone_number',
		'token',
		'status',
		'slug',
		'province_id',
		'status'
	];
	// use SoftDeletes;

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function courses()
	{
		return $this->hasMany(Course::class, 'teacher_id');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

	public function bills()
	{
		return $this->hasMany(Bill::class);
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class);
	}

	public function inboxs()
	{
		$user_id = $this->id;
		$inboxs = Notification::join('notification_user', 'notifications.id', '=', 'notification_user.notification_id')
			->where('notification_user.user_id', '=', $user_id)
			->where('notification_user.status', '=', 0)
			->select('notifications.*', 'notification_user.id as inboxId')
			->get();
		return $inboxs;
	}

	public function isVip()
	{
		$roleIds = $this->roles->pluck('id')->toArray();
		$allowedRoleIds = [1, 4, 5];
		if (!empty(array_intersect($roleIds, $allowedRoleIds))) {
			return true;
		} else return false;
	}

	public function isSupport()
	{
		$roleIds = $this->roles->pluck('id')->toArray();
		$allowedRoleIds = [5];
		if (!empty(array_intersect($roleIds, $allowedRoleIds))) {
			return true;
		} else return false;
	}


	public function getName($hello)
	{
		return $hello;
	}


	public function department()
	{
		return $this->courses()->first()->department;
	}


	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function carts()
	{
		return $this->hasMany(Cart::class);
	}

	public function wishlists()
	{
		return $this->hasMany(Wishlist::class);
	}

	public function byReviews()
	{
		$total = 0;
		foreach ($this->courses as $course) {
			$total += count($course->reviews);
		}
		if (0 < $total & $total < 10) {
			return '0' . $total;
		}
		return $total;
	}

	public function byRate()
	{
		$totalRate = 0;
		$numberReviews = 0;
		foreach ($this->courses as $course) {
			foreach ($course->reviews as $review) {
				$numberReviews++;
				$totalRate += $review->rate;
			}
		}
		if ($numberReviews == 0) {
			return 0;
		}
		return round($totalRate / $numberReviews, 1);
	}

	public function students()
	{
		$students = 0;
		foreach ($this->courses as $course) {
			$students += count($course->bills);
		}
		if (0 < $students & $students < 10) {
			return '0' . $students;
		}
		return $students;
	}

	public function unreadNotices()
	{
		$notices = NotificationUser::where('user_id', Auth::id())
			->where('status', 0)->get();
		if ($notices) {
			return count($notices);
		}
		return 0;
	}

	public function unreadMessages()
	{
		$messages = Message::where('receiver', Auth::user()->unique_id)
			->where('status', 0)->get();
		if ($messages) {
			return count($messages);
		}
		return 0;
	}
}
