<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CheckPermission
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next, $permission): Response
	{
		$permission_id = Permission::where('key_code', $permission)->first()->id;
		$permissions = DB::table('users')
			->join('role_user', 'users.id', '=',  'role_user.user_id')
			->join('permission_role', 'role_user.role_id', '=',  'permission_role.role_id')
			->where('users.id', Auth::id())
			->get()->unique();
		if ($permissions->contains('permission_id', $permission_id)) {
			return $next($request);
		} else {
			abort(403);
		}
	}
}
