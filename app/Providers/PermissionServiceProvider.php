<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		Blade::if('hasPermission', function ($environment) {
			$permission = Permission::where('key_code', $environment)->first();
			if ($permission) {
				$roles = Auth::user()->roles;
				foreach ($roles as $role) {
					$permissions = $role->permissions;
					if ($permissions->contains($permission)) return true;
				}
				return false;
			}
			return false;
		});
	}
}
