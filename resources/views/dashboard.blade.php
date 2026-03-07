<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - Comments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Comment Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-200">
                <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="body" class="sr-only">Your comment</label>
                        <textarea id="body" name="body" rows="3" 
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-black resize-none transition-all"
                            placeholder="What's on your mind, {{ Auth::user()->name }}?" required></textarea>
                        @error('body')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-black text-white font-semibold shadow hover:bg-gray-800 transition-colors duration-200">
                            Post Comment
                        </button>
                    </div>
                </form>
            </div>

            <div class="h-px w-full bg-gray-200 my-8"></div>

            <!-- Comments List -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                    </svg>
                    Recent Comments
                    <span class="bg-gray-100 text-gray-600 text-xs py-1 px-2.5 rounded-full ml-1">{{ $comments->count() }}</span>
                </h3>

                @forelse ($comments as $comment)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow transition-shadow">
                        <div class="flex gap-4">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-black flex items-center justify-center text-white font-bold shadow-inner">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-sm font-bold text-gray-900 truncate">
                                        {{ $comment->user->name }}
                                    </h4>
                                    <time class="text-xs text-gray-500 ml-4 flex-shrink-0" datetime="{{ $comment->created_at->toIso8601String() }}">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </time>
                                </div>
                                <p class="text-gray-700 text-sm leading-relaxed break-words mt-1">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 px-4 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 border border-gray-200 shadow-sm">
                            <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h4 class="text-gray-900 font-medium text-sm">No comments yet</h4>
                        <p class="text-gray-500 text-sm mt-1">Be the first to share your thoughts!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
