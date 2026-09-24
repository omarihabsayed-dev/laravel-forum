<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="min-h-screen bg-gray-50 py-6 lg:py-10">
                @auth
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col gap-6 md:flex-row lg:gap-8">

                            <!-- Sidebar -->
                            <aside class="w-full shrink-0 md:w-64 lg:w-72">
                                <div class="md:sticky md:top-6">
                                    <div class="rounded-xl border border-gray-200/80 bg-white p-4 shadow-sm">
                                        <h3 class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                            Channels
                                        </h3>

                                        @if($channels->isEmpty())
                                            <p class="px-3 py-2 text-sm text-gray-500">No channels yet.</p>
                                        @else
                                            <ul class="space-y-1">
                                                @foreach($channels as $channel)
                                                    @php $active = request()->route('channel') == $channel->id; @endphp
                                                    <li>
                                                        <a href=""
                                                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition-colors
                                                                {{ $active
                                                                    ? 'bg-gray-100 font-medium text-gray-900'
                                                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                                            <span class="text-gray-400">#</span>
                                                            <span class="truncate">{{ $channel->name }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </aside>

                            <!-- Main content area -->
                            <section class="min-w-0 flex-1">
                                <!-- Action Bar (Aligned to Right) -->
                                 @unless(request()->routeIs('discussion.create'))
                                    <div class="mb-6 flex justify-end">
                                        <a href="{{ route('discussion.create') }}" 
                                        class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                            <span>Add Discussion</span>
                                        </a>
                                    </div>
                                @endunless

                                {{ $slot }}
                            </section>

                        </div>
                    </div>
                @else
                    <!-- Guest view -->
                    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                @endauth
            </main>
        </div>
    </body>
</html>
