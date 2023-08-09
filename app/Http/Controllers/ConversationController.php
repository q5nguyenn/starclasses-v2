<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ConversationController extends Controller
{

	public $visitor;
	public $employee;
	public $conversation;

	function __construct()
	{
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$visitor = Visitor::where('ip_address', $ip_address)->first();
		if (!$visitor) {
			$visitor = new Visitor();
			$visitor->ip_address = $ip_address;
			$visitor->user_agent = $ip_address;
			$visitor->save();
		}
		$employee = User::join('role_user', 'users.id', '=', 'role_user.user_id')
			->where('role_user.role_id', 5)
			->first();
		$conversation = Conversation::where('employee_unique_id', $employee->unique_id)
			->where('guest_unique_id', $visitor->unique_id)->first();
		$this->visitor = $visitor;
		$this->employee = $employee;
		$this->conversation = $conversation;
	}

	function getEmployee(Request $request)
	{
		$visitor = $this->visitor;
		$employee = $this->employee;
		$newEmployee = false;
		//Tạo đoạn hội thoại
		$conversation = $this->conversation;
		if (!$conversation) {
			$conversation = Conversation::create([
				'employee_unique_id' => $employee->unique_id,
				'guest_unique_id' => $visitor->unique_id
			]);
			$newEmployee = true;
		}
		//Support chào khách hàng'
		if ($newEmployee) {
			$content = "Hello! My name is " . $employee->name . ". Can I help you?";
			$sender = $employee->unique_id;
			$receiver = $visitor->unique_id;
			$conversation_id = $conversation->id;
			Message::create([
				'content' => $content,
				'sender' => $sender,
				'receiver' => $receiver,
				'conversation_id' => $conversation_id
			]);
		}
		return response()->json([
			'newEmployee' => $newEmployee,
			'employee' => $employee
		]);
	}

	function createMessage(Request $request)
	{
		$visitor = $this->visitor;
		$employee = $this->employee;
		$conversation = $this->conversation;
		$content = $request->input('content');
		$message = Message::create([
			'content' => $content,
			'conversation_id' => $conversation->id,
			'sender' => $visitor->unique_id,
			'receiver' => $employee->unique_id
		]);
		return $message;
	}

	function getMessage(Request $request)
	{
		$visitor = $this->visitor;
		$employee = $this->employee;
		$conversation = $this->conversation;
		$messages = $conversation->messages;
		$newMessage = 0;
		foreach ($messages as $message) {
			if ($message->status == 0 && $message->sender == $employee->unique_id) {
				$message->update(['status' => 1]);
				$newMessage++;
			}
		}
		return response()->json([
			'messages' => $messages,
			'employee' => $employee,
			'newMessage' => $newMessage
		]);
	}
}
