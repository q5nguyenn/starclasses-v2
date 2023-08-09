<?php

namespace App\Models;

use App\Models\Permission as ModelsPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
	use HasFactory;
	protected $fillable = [
		'name',
		'description',
		'key_code',
		'parent_id',
	];
	public function permissionChilds()
	{
		return $this->hasMany(ModelsPermission::class, 'parent_id');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}
}
