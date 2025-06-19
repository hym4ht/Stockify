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
