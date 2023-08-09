<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller
{
	public function index(Request $request)
	{
		$list = Role::paginate(10);
		return view('admin.role.index', [
			'list' => $list
		]);
	}

	public function create(Request $request)
	{
		$list = Permission::where('parent_id', 0)->get();
		return view('admin.role.create', [
			'list' => $list
		]);
	}

	public function store(RoleRequest $request)
	{
		$role = Role::create([
			'name' => $request->name,
			'description' => $request->description
		]);
		$role->permissions()->attach($request->permissions);
		return redirect()->route('admin.role.index');
	}

	public function edit(Request $request)
	{
		$role = Role::find($request->id);
		$list = Permission::where('parent_id', 0)->get();
		$role_permissions = $role->permissions;
		// dd($role_permissions )
		return view('admin.role.edit', [
			'list' => $list,
			'role' => $role,
			'role_permissions' => $role_permissions

		]);
	}

	public function update(RoleRequest $request)
	{
		$role = Role::find($request->id);
		$role->permissions()->sync($request->permissions);
		$role->update([
			'name' => $request->name,
			'description' => $request->description
		]);
		return redirect()->route('admin.role.index');
	}

	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$role = Role::find($request->id);
			if ($role) {
				$role->permissions()->detach();
				$role->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Role not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete role because there are related somethings!'
			]);
		}
	}
}
