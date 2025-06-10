@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Chat with {{ $chatUser->name }}</h1>
    <div class="border rounded p-4 mb-4 max-h-96 overflow-y-auto" id="chatMessagesContent">
        @foreach($messages as $message)
            <div class="mb-2 {{ $message->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                <div class="inline-block p-2 rounded {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                    {{ $message->message }}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    {{ $message->created_at->format('H:i, d M Y') }}
                </div>
            </div>
        @endforeach
    </div>
    <form action="{{ route('chat.send') }}" method="POST" class="flex space-x-2">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $chatUser->id }}">
        <input type="text" name="message" placeholder="Type your message..." required class="flex-grow border rounded p-2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>
    </form>
</div>
@endsection
