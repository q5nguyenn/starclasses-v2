<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $fillable = [
		'name', 'description'
	];
	public $timestamps = false;
	use HasFactory;

	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	public function permissions()
	{
		return $this->belongsToMany(Permission::class);
	}
}
