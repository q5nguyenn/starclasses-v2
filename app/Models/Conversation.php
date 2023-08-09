<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
	use HasFactory;
	protected $fillable = [
		'employee_unique_id',
		'guest_unique_id'
	];

	function messages()
	{
		return $this->hasMany(Message::class);
	}

	function visitor()
	{
		$guest_unique_id = $this->guest_unique_id;
		$visitor = Visitor::where('unique_id', $guest_unique_id)->first();
		return $visitor;
	}

	function getLastMesssage()
	{
		$user = Auth::user();
		return $this->messages()
			->where('receiver', $user->unique_id)
			->latest()->first();
	}

	function unreadMessages()
	{
		$user = Auth::user();
		$messages = Message::where('receiver', Auth::user()->unique_id)
			->where('conversation_id', $this->id)
			->where('status', 0)->get();
		if ($messages) {
			return count($messages);
		}
		return 0;
	}
}
