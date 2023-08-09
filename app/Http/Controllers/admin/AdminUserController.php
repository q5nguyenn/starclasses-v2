<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Http\Requests\UserRequest;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\Utilities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$list = User::paginate(10);
		$roles = Role::all();
		return view('admin.user.index', [
			'list' => $list,
			'roles' => $roles,
		]);
	}
	public function create(Request $request)
	{
		$provinces = Province::all();
		$roles = Role::all();
		return view('admin.user.create', [
			'roles' => $roles,
			'provinces' => $provinces
		]);
	}
	public function store(UserRequest $request)
	{
		$url = $this->storeUpload($request, 'thumbnail', 'thumbnails');
		if (empty($url)) {
			$url = "/images/user.png";
		}
		if (!isset($request->birth_day)) {
			$birth_day = date("Y-m-d");
		} else {
			$birth_day = $request->birth_day;
		}
		$user = User::create([
			'thumbnail' => $url,
			'description' => $request->description,
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'birth_day' => $birth_day,
			'phone_number' => $request->phone_number,
			'province_id' => $request->province_id,
		]);
		$user->update([
			'slug' => Str::slug($user->name, '-') . '-' . $user->id,
		]);
		$roles = $request->roles;
		if (empty($roles)) {
			$roles = [2];
		}
		$user->roles()->attach($roles);
		return redirect()->route('admin.user.index');
	}
	public function edit(Request $request)
	{
		$provinces = Province::all();
		$id = $request->id;
		$user = User::find($id);
		$user_roles = $user->roles->pluck('id')->toArray();
		$roles = Role::all();
		return view('admin.user.edit', [
			'user' => $user,
			'user_roles' => $user_roles,
			'roles' => $roles,
			'provinces' => $provinces
		]);
	}
	public function update(Request $request)
	{
		$user = User::find($request->id);
		$rules = [
			'name' => 'bail|required|min:5|max:100',
			'email' => [
				'required',
				'email',
				Rule::unique('users', 'email')->ignore($user),
			],
			'password' => 'sometimes|required',
			'roles' => 'required',
			'phone_number' => [
				'nullable',
				'regex:/^(0)?[0-9]{9}$/',
				Rule::unique('users', 'phone_number')->ignore($user),
			],
			'thumbnail' => [
				'nullable',
				'image',
				'max:500', // Max file size in kilobytes (KB)
			],
		];

		$customMessages = [
			'name.required' => '*Name field cannot be left blank.',
			'name.min' => '*Username must contain at least 5 and 100 characters.',
			'name.max' => '*Username must contain at least 5 and 100 characters.',
			'email.required' => '*Email field cannot be left blank.',
			'email.email' => '*Email invalidate.',
			'email.unique' => '*Email already exists.',
			'password.required' => '*Password field cannot be left blank.',
			'roles.required' => '*Role field cannot be left blank.',
			'phone_number.unique' => '*Phone number already exists.',
			'phone_number.regex' => '*Phone number invalidate.',
			'thumbnail.image' => '*The file must be an image.',
			'thumbnail.max' => '*The image size must be smaller than 500KB.',
		];

		$request->validate($rules, $customMessages);
		$user = User::find($request->id);
		$url = $this->storeUpload($request, 'thumbnail', 'thumbnails');
		if (empty($url)) {
			$url = $user->thumbnail;
		} else {
			$this->deleteFile($user->thumbnail);
		}
		$user->update([
			'thumbnail' => $url,
			'description' => $request->description,
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'birth_day' => $request->birth_day,
			'phone_number' => $request->phone_number,
			'province_id' => $request->province_id,
		]);
		$user->update([
			'slug' => Str::slug($user->name, '-') . '-' . $user->id,
		]);
		if ($request->has('change-password')) {
			$user->update([
				'password' => bcrypt($request->password),
			]);
		}
		$user->roles()->sync($request->roles);
		return redirect()->route('admin.user.index');
	}

	public function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$user = User::find($request->id);
			if ($user) {
				$thumbnail = $user->thumbnail;
				$tags = $user->roles;
				$user->roles()->detach();
				$user->delete();
				$this->deleteFile($thumbnail);
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'User not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete user because there are related somethings!'
			]);
		}
	}

	public function search(Request $request)
	{
		$role_id = $request->role_id;
		$query = User::join('role_user', 'users.id', '=', 'role_user.user_id')
			->select('users.*')
			->where(function ($query) use ($request) {
				$query->where('name', 'like', '%' . $request->keyword . '%')
					->orWhere('email', 'like', '%' . $request->keyword . '%')
					->orWhere('phone_number', 'like', '%' . $request->keyword . '%');
			});
		if (!empty($role_id)) {
			$query->where('role_user.role_id', '=', $role_id);
		}
		$list = $query;
		$count = $this->numberDisplay(count($list->get()));
		$list = $list->paginate(10);
		$roles = Role::all();
		return view('admin.user.index', [
			'list' => $list,
			'roles' => $roles,
			'count' => $count,
			'keyword' => $request->keyword,
			'role_id' => $role_id
		]);
	}
}
