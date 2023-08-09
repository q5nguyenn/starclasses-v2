<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatAppController extends Controller
{

	function index(Request $request)
	{
		$user = Auth::user();
		$id = $request->id;
		if (!$id) {
			$conversation = Conversation::where('employee_unique_id', Auth::user()->unique_id)
				->latest('updated_at')
				->first();
		} else {
			$conversation = Conversation::find($id);
		}
		$conversations = Conversation::where('employee_unique_id', Auth::user()->unique_id)->get();
		$visitor = $conversation->visitor();
		$messages = $conversation->messages;
		return view(
			'admin.chat-app.index',
			[
				'conversation' => $conversation,
				'messages' => $messages,
				'visitor' => $visitor,
				'conversations' => $conversations
			]
		);
	}
	function send(Request $request)
	{
		$conversation_id = $request->input('conversation_id');
		$conversation = Conversation::find($conversation_id);
		$visitor = $conversation->visitor();
		$message = Message::create([
			'content' => $request->content,
			'sender' => Auth::user()->unique_id,
			'receiver' => $visitor->unique_id,
			'conversation_id' => $conversation->id
		]);
		return $message;
	}

	function get(Request $request)
	{
		$conversation_id = $request->input('conversation_id');
		$conversation = Conversation::find($conversation_id);
		$visitor = $conversation->visitor();
		$employee = Auth::user();
		$messages = $conversation->messages;
		$newMessage = 0;
		foreach ($messages as $message) {
			if ($message->status == 0 && $message->sender == $visitor->unique_id) {
				$message->update(['status' => 1]);
				$newMessage++;
			}
		}
		return response()->json([
			'messages' => $messages,
			'visitor' => $visitor,
			'newMessage' => $newMessage
		]);
	}
}
