<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NavbarDashboard extends Component
{
    public $conversations;
    public $users;
    public $unreadCount;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $userId = Auth::id();

        // Get distinct users who have chatted with the authenticated user
        $conversations = Message::where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->orWhere('receiver_id', $userId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
            });

        $this->conversations = $conversations;

        // Get users for each conversation
        $this->users = User::whereIn('id', $conversations->keys())->get()->keyBy('id');

        // Count distinct users who have unread messages for badge
        $this->unreadCount = Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->distinct('sender_id')
            ->count('sender_id');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar-dashboard', [
            'conversations' => $this->conversations,
            'users' => $this->users,
            'unreadCount' => $this->unreadCount,
        ]);
    }
}
