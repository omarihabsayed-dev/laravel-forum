<x-app-layout>
    <div class="space-y-4 max-w-4xl mx-auto">
        <!-- Top Navigation / Back Button -->
        <div>
            <a href="{{ route('discussion.index') }}" class="inline-flex items-center text-xs font-semibold text-gray-400 hover:text-gray-900 transition-colors gap-1">
                &larr; Back to discussions
            </a>
        </div>

        <!-- Success Flash Message -->
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50/50 p-4 text-xs font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <!-- Main Card -->
        <article class="rounded-xl border border-gray-200/80 bg-white p-6 shadow-sm">
            <!-- Header -->
            <div class="flex items-center justify-between text-xs text-gray-500 mb-6 pb-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-gray-900 text-white flex items-center justify-center font-semibold text-xs">
                        {{ strtoupper(substr($discussion->user?->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 text-sm">
                            {{ $discussion->user?->name ?? 'Anonymous' }}
                        </div>
                        <time datetime="{{ $discussion->created_at->toIso8601String() }}" class="text-gray-400">
                            {{ $discussion->created_at->diffForHumans() }}
                        </time>
                    </div>
                </div>

                <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                    # {{ $discussion->channel?->name ?? 'General' }}
                </span>
            </div>

            <!-- Discussion Content -->
            <h1 class="text-xl font-bold text-gray-900 mb-4 tracking-tight">
                {{ $discussion->title }}
            </h1>

            <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                {{ $discussion->content }}
            </div>
        </article>

        <!-- Replies Section -->
        <div class="space-y-4 pt-4">
            <h2 class="text-xs font-semibold tracking-wider text-gray-400 uppercase px-1">
                Replies ({{ $discussion->replies->count() }})
            </h2>

            <!-- Existing Replies List -->
            <div class="space-y-3">
                @forelse ($discussion->replies as $reply)
                    <div class="rounded-xl border border-gray-200/80 bg-white p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-8 w-8 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center font-semibold text-xs border border-gray-200">
                                {{ strtoupper(substr($reply->user?->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-xs">
                                    {{ $reply->user?->name ?? 'Anonymous' }}
                                </div>
                                <time datetime="{{ $reply->created_at->toIso8601String() }}" class="text-xs text-gray-400">
                                    {{ $reply->created_at->diffForHumans() }}
                                </time>
                            </div>
                        </div>

                    <div class="flex items-center gap-2">
                        @if ($discussion->reply_id === $reply->id)
                            <!-- Best Reply Badge -->
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Best reply
                            </span>
                        @elseif (auth()->check() && auth()->id() === $discussion->user_id)
                            <!-- Mark as Best Button (Only visible to Discussion Owner) -->
                            <form action="{{ route('discussions.best-reply', [$discussion, $reply]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="text-xs font-medium text-gray-400 hover:text-emerald-600 transition-colors">
                                    Mark as Best
                                </button>
                            </form>
                        @endif
                    </div>

                        <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $reply->content }}
                        </div>
                    </div> 
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 bg-white/50 p-6 text-center text-xs text-gray-400">
                        No replies yet. Start the conversation below!
                    </div>
                @endforelse
            </div>

            <!-- Add Reply Form -->
            <form action="{{ route('replies.store', $discussion) }}" method="POST" class="rounded-xl border border-gray-200/80 bg-white p-4 shadow-sm space-y-3">
                @csrf
                <div>
                    <label for="content" class="sr-only">Your Reply</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="3" 
                        required
                        placeholder="Write a reply..." 
                        class="w-full resize-none border-0 p-0 text-sm text-gray-900 focus:ring-0 placeholder:text-gray-400 focus:outline-none"
                    >{{ old('content') }}</textarea>

                    @error('content')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                    <span class="text-xs text-gray-400">Markdown supported</span>
                    <button 
                        type="submit" 
                        class="inline-flex items-center rounded-lg bg-gray-900 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-gray-800 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900"
                    >
                        Post Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>