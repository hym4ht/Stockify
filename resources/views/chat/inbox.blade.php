@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Inbox</h1>
    <div class="mb-4">
        <input type="text" id="userSearch" placeholder="Search users to chat..." class="border p-2 rounded w-full" autocomplete="off" />
        <div id="searchResults" class="border rounded mt-1 max-h-48 overflow-y-auto hidden"></div>
    </div>
    <div class="flex space-x-4">
        <div class="w-1/3 border rounded p-4 max-h-[500px] overflow-y-auto">
            <h2 class="text-xl font-semibold mb-2">Users</h2>
            <ul>
                @foreach($allUsers as $user)
                    <li class="mb-4 p-4 border rounded hover:bg-gray-100 cursor-pointer" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full">
                            </div>
                            <div>
                                <p class="font-semibold">{{ $user->name }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="w-2/3">
            <div id="chatSection" class="hidden border rounded p-4 mb-4">
                <h2 class="text-xl font-semibold mb-2" id="chatWith"></h2>
                <div id="chatMessages" class="max-h-64 overflow-y-auto mb-2"></div>
                <form id="sendMessageForm">
                    <input type="hidden" id="receiverId" name="receiver_id" />
                    <textarea id="messageInput" name="message" rows="3" class="w-full border rounded p-2" placeholder="Type your message..."></textarea>
                    <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Send</button>
                </form>
            </div>
            @if($conversations->isEmpty())
                <p>No conversations yet.</p>
            @else
                <h2 class="text-xl font-semibold mb-2">Conversations</h2>
                <ul>
                    @foreach($conversations as $userId => $messages)
                        @php
                            $user = $users->get($userId);
                            $lastMessage = $messages->sortByDesc('created_at')->first();
                        @endphp
                        <li class="mb-4 p-4 border rounded hover:bg-gray-100 cursor-pointer" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full">
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $user->name }}</p>
                                    <p class="text-gray-600 text-sm truncate max-w-xs">{{ $lastMessage->message }}</p>
                                    <p class="text-gray-400 text-xs">{{ $lastMessage->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const userSearchInput = document.getElementById('userSearch');
    const searchResults = document.getElementById('searchResults');
    const chatSection = document.getElementById('chatSection');
    const chatWith = document.getElementById('chatWith');
    const chatMessages = document.getElementById('chatMessages');
    const sendMessageForm = document.getElementById('sendMessageForm');
    const receiverIdInput = document.getElementById('receiverId');
    const messageInput = document.getElementById('messageInput');

    let currentChatUserId = null;

    // Function to fetch and display search results
    userSearchInput.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length === 0) {
            searchResults.innerHTML = '';
            searchResults.classList.add('hidden');
            return;
        }

        fetch(`/chat/search-users?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(users => {
                if (users.length === 0) {
                    searchResults.innerHTML = '<p class="p-2 text-gray-600">No users found.</p>';
                } else {
                    searchResults.innerHTML = users.map(user => `
                        <div class="p-2 hover:bg-gray-200 cursor-pointer" data-user-id="${user.id}" data-user-name="${user.name}">
                            ${user.name}
                        </div>
                    `).join('');
                }
                searchResults.classList.remove('hidden');
            });
    });

    // Click on search result to start chat
    searchResults.addEventListener('click', function (e) {
        const target = e.target.closest('div[data-user-id]');
        if (!target) return;

        const userId = target.getAttribute('data-user-id');
        const userName = target.getAttribute('data-user-name');

        startChat(userId, userName);
        searchResults.innerHTML = '';
        searchResults.classList.add('hidden');
        userSearchInput.value = '';
    });

    // Click on conversation to open chat
    document.querySelectorAll('li[data-user-id]').forEach(item => {
        item.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            startChat(userId, userName);
        });
    });

    // Function to start chat with a user
    function startChat(userId, userName) {
        currentChatUserId = userId;
        chatWith.textContent = `Chat with ${userName}`;
        receiverIdInput.value = userId;
        chatMessages.innerHTML = '<p>Loading messages...</p>';
        chatSection.classList.remove('hidden');

        fetch(`/chat/${userId}`)
            .then(response => response.text())
            .then(html => {
                // Extract messages from the chat page HTML
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const messagesDiv = tempDiv.querySelector('#chatMessagesContent');
                if (messagesDiv) {
                    chatMessages.innerHTML = messagesDiv.innerHTML;
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                } else {
                    chatMessages.innerHTML = '<p>No messages found.</p>';
                }
            });
    }

    // Handle sending message form submit
    sendMessageForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message || !currentChatUserId) return;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                receiver_id: currentChatUserId,
                message: message
            })
        }).then(response => {
            if (response.ok) {
                messageInput.value = '';
                // Reload messages
                startChat(currentChatUserId, chatWith.textContent.replace('Chat with ', ''));
            } else {
                alert('Failed to send message.');
            }
        });
    });
});
</script>
@endsection
