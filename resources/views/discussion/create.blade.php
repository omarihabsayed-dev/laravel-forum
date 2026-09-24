<x-app-layout>
    <div class="mx-auto max-w-2xl rounded-2xl border border-gray-200/80 bg-white p-6 shadow-sm sm:p-8">
        <h2 class="mb-6 text-lg font-semibold text-gray-900">Create a Discussion</h2>

        <form action="{{ route('discussion.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700">
                    Title
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}" 
                    placeholder="What's on your mind?"
                    class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-colors placeholder:text-gray-400 focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                    required
                >
                @error('title')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="channel_id" class="mb-1.5 block text-sm font-medium text-gray-700">
                    Channel
                </label>
                <select 
                    name="channel_id" 
                    id="channel_id" 
                    class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                    required
                >
                    <option value="" disabled selected>Select a channel</option>
                    @foreach($channels as $channel)
                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                            {{ $channel->name }}
                        </option>
                    @endforeach
                </select>
                @error('channel_id')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="mb-1.5 block text-sm font-medium text-gray-700">
                    Content
                </label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="6" 
                    placeholder="Provide detail about your discussion..."
                    class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-colors placeholder:text-gray-400 focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                    required
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-2">
                <button 
                    type="submit" 
                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
                >
                    Create Discussion
                </button>
            </div>
        </form>
    </div>
</x-app-layout>