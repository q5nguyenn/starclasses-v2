<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
	public function before($user, $ability)
	{
		$roleIds = $user->roles->pluck('id')->toArray();
		$allowedRoleIds = [1, 4, 5];
		if (!empty(array_intersect($roleIds, $allowedRoleIds))) {
			return true;
		}
	}
	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(User $user): bool
	{
		//
	}

	/**
	 * Determine whether the user can view the model.
	 */
	public function view(User $user, Course $course): bool
	{
		return $user->id === $course->teacher_id;
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(User $user): bool
	{
		//
	}

	/**
	 * Determine whether the user can update the model.
	 */
	public function update(User $user, Course $course): bool
	{
		return $user->id === $course->teacher_id;
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user, Course $course): bool
	{
		return $user->id === $course->teacher_id;
	}

	/**
	 * Determine whether the user can restore the model.
	 */
	public function restore(User $user, Course $course): bool
	{
		//
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 */
	public function forceDelete(User $user, Course $course): bool
	{
		//
	}
}
