<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	use HasFactory;
	protected $fillable = [
		'type',
		'description',
		'status',
		'user_id'
	];
	public function reportImages()
	{
		return $this->hasMany(ReportImage::class);
	}
}
