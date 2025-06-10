<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Show inbox with list of conversations grouped by roles/users
    public function inbox()
    {
        $userId = Auth::id();

        // Get distinct users who have chatted with the authenticated user
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
            });

        // Get users for each conversation
        $users = User::whereIn('id', $conversations->keys())->get()->keyBy('id');

        // Get all users except authenticated user for full user list
        $allUsers = User::where('id', '!=', $userId)->get();

        return view('chat.inbox', compact('conversations', 'users', 'allUsers'));
    }

    // Show chat messages between authenticated user and $userId
    public function chat($userId)
    {
        $authUserId = Auth::id();

        // Fetch messages between the two users
        $messages = Message::where(function ($query) use ($authUserId, $userId) {
            $query->where('sender_id', $authUserId)->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($authUserId, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $authUserId);
        })->orderBy('created_at')->get();

        $chatUser = User::findOrFail($userId);

        return view('chat.chat', compact('messages', 'chatUser'));
    }

    // Handle sending a message
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.chat', ['userId' => $request->receiver_id]);
    }

    // Show list of users to start a chat with
    public function users()
    {
        $authUserId = Auth::id();
        $users = User::where('id', '!=', $authUserId)->get();

        return view('chat.users', compact('users'));
    }

    // API: Search users by name excluding authenticated user
    public function searchUsers(Request $request)
    {
        $authUserId = Auth::id();
        $query = $request->input('query', '');

        $users = User::where('id', '!=', $authUserId)
            ->where('name', 'like', '%' . $query . '%')
            ->limit(10)
            ->get();

        return response()->json($users);
    }
}
