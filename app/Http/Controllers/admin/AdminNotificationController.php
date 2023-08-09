<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminNotificationController extends Controller
{
	use Utilities;
	public function index(Request $request)
	{
		$user = Auth::user();
		$list = Notification::join('notification_user', 'notifications.id', '=', 'notification_user.notification_id')
			->where('notification_user.user_id', '=', $user->id)
			->select('notifications.*', 'notification_user.id as inboxId', 'notification_user.status as status');
		$list = $list->paginate(10);
		return view('admin.notification.index', [
			'list' => $list
		]);
	}

	public function sent(Request $request)
	{
		$user = Auth::user();
		$list = Notification::join('users', 'notifications.user_id', '=', 'users.id')
			->where('users.id', '=', $user->id)
			->select('notifications.*')
			->paginate(10);
		return view('admin.notification.sent', [
			'list' => $list
		]);
	}

	public function read(Request $request)
	{
		$user = Auth::user();
		$notification_user = NotificationUser::find($request->id);
		if ($user->cannot('view', $notification_user)) {
			return redirect()->route('admin.notification.index');
		}
		$notification = $notification_user->notificaton;
		$notification_user->update(['status' => 1]);
		return view('admin.notification.read', [
			'notification' => $notification,
			'notification_user' => $notification_user
		]);
	}

	public function create(Request $request)
	{
		$to_user = User::find($request->to);
		$users = User::all();
		return view('admin.notification.create', [
			'users' => $users,
			'to_user' => $to_user
		]);
	}

	public function store(NotificationRequest $request)
	{
		$users = $request->users;
		$notification = Notification::create([
			'user_id' => Auth::id(),
			'title' => $request->title,
			'content' => $request->description
		]);
		$notification->users()->attach($users);
		return redirect()->route('admin.notification.sent');
	}

	public function edit(Request $request)
	{
		$user = Auth::user();
		$users = User::all();
		$id = $request->id;
		$notification = Notification::find($id);
		if ($user->cannot('view', $notification)) {
			return redirect()->route('admin.notification.sent');
		}
		return view('admin.notification.edit', [
			'notification' => $notification,
			'users' => $users
		]);
	}

	public function update(NotificationRequest $request)
	{
		$notification  = Notification::find($request->id);
		$users = $request->users;
		$user = Auth::user();
		if ($user->cannot('view', $notification)) {
			return redirect()->route('admin.notification.sent');
		}
		$notification->update([
			'title' => $request->title,
			'content' => $request->description
		]);
		$notification->users()->sync($users);
		return redirect()->route('admin.notification.sent');
	}

	//Xoá thư đã nhận
	public function delete(Request $request)
	{
		$user = Auth::user();
		$notification_user = NotificationUser::find($request->id);
		if ($user->cannot('delete', $notification_user)) {
			return redirect()->route('admin.notification.index');
		}
		$notification_user->delete();
	}

	public function sentDelete(Request $request)
	{
		$notification = Notification::find($request->id);
		if (!$notification) {
			return redirect()->route('admin.notification.sent');
		}
		$users = $notification->users;
		$user = Auth::user();
		if ($user->cannot('view', $notification)) {
			return redirect()->route('admin.notification.sent');
		}
		$notification->users()->detach($users);
		$notification->delete();
	}

	public function sentSearch(Request $request)
	{
		$sort_by = $request->sort_by;
		$query = Notification::join('users', 'users.id', '=', 'notifications.user_id')
			->where('email', 'like', '%' . $request->keyword . '%')
			->orWhere('title', 'like', '%' . $request->keyword . '%')
			->orWhereRaw("DATE_FORMAT(notifications.created_at, '%d-%m-%Y') LIKE ?", ['%' . $request->keyword . '%'])
			->select('notifications.*', 'users.email');
		if (!empty($sort_by)) {
			if ($sort_by == 'newest') {
				$query->orderBy('notifications.created_at', 'desc');
			} else {
				$query->orderBy('notifications.created_at', 'asc');
			}
		}
		$list = $query;
		$count = $this->numberDisplay(count($list->get()));
		$list = $list->paginate(10);
		return view('admin.notification.sent', [
			'list' => $list,
			'count' => $count,
			'keyword' => $request->keyword,
			'sort_by' => $sort_by
		]);
	}

	public function search(Request $request)
	{
		$user = Auth::user();
		$sort_by = $request->sort_by;
		$query = Notification::join('users', 'users.id', '=', 'notifications.user_id')
			->join('notification_user', 'notifications.id', '=', 'notification_user.notification_id')
			->where('notification_user.user_id', '=', $user->id);
		$query->where(function ($query) use ($request) {
			$query->where('title', 'like', '%' . $request->keyword . '%')
				->orWhere('email', 'like', '%' . $request->keyword . '%')
				->orWhereRaw("DATE_FORMAT(notifications.created_at, '%d-%m-%Y') LIKE ?", ['%' . $request->keyword . '%']);
		});
		$query->select('notifications.*', 'users.email', 'notification_user.id as inboxId', 'notification_user.status as status');
		if (!empty($sort_by)) {
			if ($sort_by == 'newest') {
				$query->orderBy('notifications.created_at', 'desc');
			} else {
				$query->orderBy('notifications.created_at', 'asc');
			}
		}
		$list = $query;
		$count = $this->numberDisplay(count($list->get()));
		$list = $list->paginate(10);
		return view('admin.notification.index', [
			'list' => $list,
			'count' => $count,
			'keyword' => $request->keyword,
			'sort_by' => $sort_by
		]);
	}
}
