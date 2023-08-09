<?php

namespace App\Http\Controllers;

use App\Models\OnlineUser;
use Illuminate\Http\Request;

class CountController extends Controller
{
	function onlineUser()
	{
		$maxActivityTime = now()->subMinutes(5);
		$onlineUsersCount = OnlineUser::where('last_activity', '>', $maxActivityTime)->count();
		OnlineUser::where('last_activity', '<', $maxActivityTime)->delete();
		return 	$onlineUsersCount;
	}
}
