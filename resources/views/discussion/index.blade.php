<x-app-layout>
    <div class="space-y-4">
        @forelse($discussions as $discussion)
            <div class="rounded-xl border border-gray-200/80 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-900">{{ $discussion->user->name }}</span>
                        <span>&bull;</span>
                        <time datetime="{{ $discussion->created_at->toIso8601String() }}">
                            {{ $discussion->created_at->diffForHumans() }}
                        </time>
                    </div>

                    <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">
                        # {{ $discussion->channel->name }}
                    </span>
                </div>

                <h2 class="text-lg font-semibold text-gray-900 mb-2 hover:text-gray-700">
                    <a href="{{ route('discussion.show', $discussion->slug) }}">
                        {{ $discussion->title }}
                    </a>
                </h2>

                <p class="text-sm text-gray-600 line-clamp-2">
                    {{ $discussion->content }}
                </p>
            </div>
        @empty
            <div class="rounded-xl border border-gray-200/80 bg-white p-12 text-center shadow-sm">
                <p class="text-sm text-gray-500">No discussions found yet.</p>
            </div>
        @endforelse

        <!-- Pagination Links -->
        <div class="pt-2">
            {{ $discussions->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>