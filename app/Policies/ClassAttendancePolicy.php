<?php

namespace App\Policies;

use App\Models\ClassAttendance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassAttendancePolicy
{
	use HandlesAuthorization;

	public function view(User $user, ClassAttendance $classAttendance)
	{
		return $user->isATeacherOf($classAttendance->class_id);
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  User  $user
	 * @return mixed
	 */
	public function create(User $user, $injected)
	{
		return $user->isATeacherOf($injected['class_id']);
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  User  $user
	 * @param  ClassAttendance  $classAttendance
	 * @return mixed
	 */
	public function update(User $user, ClassAttendance $classAttendance)
	{
		return $user->isATeacherOf($classAttendance->class_id);
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  User  $user
	 * @param  ClassAttendance  $classAttendance
	 * @return mixed
	 */
	public function delete(User $user, ClassAttendance $classAttendance)
	{
		//
		return $user->isATeacherOf($classAttendance->class_id);
	}
}
