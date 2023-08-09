<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
	//Update status
	function update(Request $request)
	{
		$decrease = 0;
		$id = $request->id;
		$noti = NotificationUser::join('notifications', 'notification_user.notification_id', '=', 'notifications.id')
			->where('notifications.id', '=', $id)
			->where('notification_user.user_id', Auth::id())
			->select('notification_user.*')
			->first();
		if ($noti->status == 0) {
			$noti->status = 1;
			$noti->save();
			$decrease = -1;
		}
		$notices = NotificationUser::where('user_id', Auth::id())
			->where('status', '0')->get();
		return response()->json([
			'decrease' => $decrease,
			'noticeCount' => count($notices)
		]);
	}

	function create(Request $request)
	{
		$to_user = User::find($request->to);
		$users = User::all();
		$notification = Notification::find($request->notification);
		if (!$request->all()) {
			return response()->json([
				'users' => $users,
				'type' => 'compose'
			]);
		};
		if ($request->has('forward')) {
			return response()->json([
				'users' => $users,
				'notification' => $notification,
				'type' => 'forward'
			]);
		}
		return response()->json([
			'to_user' => $to_user,
			'users' => $users,
			'notification' => $notification,
			'type' => 'reply'
		]);
	}

	function store(Request $request)
	{
		$users = $request->input('users');
		$title = $request->input('title');
		$content = $request->input('content');
		$data = [
			'user_id' => Auth::id(),
			'title' => $title,
			'content' => $content
		];
		$notification = Notification::create($data);
		$notification->users()->attach($users);
		return response()->json(['status' => 'success']);
	}

	function edit(Request $request)
	{
		$users = User::all();
		$notification = Notification::find($request->notification);
		$to_user = $notification->users;
		return response()->json([
			'to_user' => $to_user,
			'users' => $users,
			'notification' => $notification,
			'type' => 'edit'
		]);
	}

	//Update body
	function save(Request $request)
	{
		$id = $request->input('notification-id');
		$users = $request->input('users');
		$title = $request->input('title');
		$content = $request->input('content');
		$notification = Notification::find($id);
		$notification->title = $title;
		$notification->content = $content;
		$notification->save();
		$notification->users()->sync($users);
		return response()->json(['status' => 'success']);
	}

	function sentDelete(Request $request)
	{
		try {
			DB::beginTransaction();
			$notification = Notification::find($request->id);;
			if ($notification) {
				$users = $notification->users;
				$notification->users()->detach($users);
				$notification->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Notification not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete notification because there are related departments!'
			]);
		}
	}

	function delete(Request $request)
	{
		try {
			DB::beginTransaction();
			$notification = NotificationUser::find($request->id);
			if ($notification) {
				$notification->delete();
				DB::commit();
				return response()->json([
					'status' => 1,
					'message' => 'Success'
				]);
			} else {
				return response()->json([
					'status' => 0,
					'message' => 'Notification not found!'
				]);
			}
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json([
				'status' => -1,
				'message' => 'Cannot delete notification because there are related departments!'
			]);
		}
	}
}
