<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Course;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Policies\CoursePolicy;
use App\Policies\NotificationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The model to policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [
		//
		Course::class => CoursePolicy::class,
		Notification::class => NotificationPolicy::class,
		NotificationUser::class => NotificationUserPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 */
	public function boot(): void
	{
		Gate::define('checkLogin', function (User $user) {
			return Auth::check();
		});
		Gate::define('view-course', function ($user, $course) {
			$role_teacher = Role::find('3');
			$permission = Permission::where('key_code', 'course_lists')->first();
			$roles = $user->roles;
			if ($roles->contain($role_teacher)) {
				return $user->id === $course->teacher_id;
			} else {
				foreach ($roles as $role) {
					$permissions = $role->permissions;
					if ($permissions->contains($permission)) return true;
				}
			}
			return false;
		});
	}
}
