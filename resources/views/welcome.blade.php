<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Premium Feed</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-[Inter] antialiased bg-black text-white min-h-screen selection:bg-white/30 selection:text-black">

    <!-- Navbar/Auth Links -->
    <nav class="fixed w-full z-50 top-0 border-b border-white/10 bg-black/50 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex-shrink-0 flex items-center">
                <span class="text-xl font-bold text-white tracking-widest uppercase">Chripre</span>
            </div>
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition px-4">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition px-4 border-r border-white/10">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-medium text-slate-300 hover:text-white transition px-4">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto relative">
        
        <!-- Ambient background glows -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-2xl h-[400px] bg-white/5 rounded-full blur-[120px] pointer-events-none"></div>

        <!-- Hero -->
        <div class="text-center mb-16 relative">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 mt-12 text-white">
                Join the <br class="hidden sm:block"/> 
                <span class="text-gray-400">Conversation</span>
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Share your thoughts, connect with others, and experience a beautifully crafted environment built for modern interactions.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl backdrop-blur-sm text-center font-medium">
                {{ session('success') }}
            </div>
        @endif

        <!-- Interaction Area -->
        <div class="space-y-8 relative">
            
            <!-- Comment Form -->
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl">
                @auth
                    <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="body" class="sr-only">Your comment</label>
                            <textarea id="body" name="body" rows="3" 
                                class="w-full bg-black border border-white/20 rounded-2xl p-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white resize-none transition-all"
                                placeholder="What's on your mind, {{ Auth::user()->name }}?" required></textarea>
                            @error('body')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-white text-black font-semibold shadow-lg hover:bg-gray-200 hover:-translate-y-0.5 transition-all duration-200">
                                Post Comment
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                            <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-200 mb-2">Sign in to join the discussion</h3>
                        <p class="text-sm text-slate-400 mb-6">You need an account to post comments.</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-white text-slate-900 font-semibold hover:bg-slate-100 transition-colors">
                            Sign In
                        </a>
                    </div>
                @endauth
            </div>

            <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-12"></div>

            <!-- Comments List -->
            <div class="space-y-6">
                <h2 class="text-xl font-semibold text-white flex items-center gap-2 mb-8">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                    </svg>
                    Recent Thoughts
                    <span class="bg-white/10 text-xs py-1 px-2.5 rounded-full ml-2">{{ $comments->count() }}</span>
                </h2>

                @forelse ($comments as $comment)
                    <div class="group bg-white/5 hover:bg-white/[0.07] backdrop-blur-md border border-white/5 rounded-2xl p-5 sm:p-6 transition-colors duration-300">
                        <div class="flex gap-4">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-black font-bold text-lg shadow-inner ring-2 ring-black border border-gray-200">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="text-base font-medium text-white truncate">
                                        {{ $comment->user->name }}
                                    </h3>
                                    <time class="text-xs text-slate-500 ml-4 flex-shrink-0" datetime="{{ $comment->created_at->toIso8601String() }}">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </time>
                                </div>
                                <p class="text-gray-300 text-sm sm:text-base leading-relaxed break-words">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 px-4 rounded-3xl border border-dashed border-white/10 bg-white/[0.02]">
                        <div class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h4 class="text-slate-300 font-medium mb-1">No comments yet</h4>
                        <p class="text-slate-500 text-sm">Be the first to share your thoughts!</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </main>

</body>
</html>