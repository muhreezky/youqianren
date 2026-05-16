<nav class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/20">
                    Y
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">YouQianRen <span class="text-emerald-600 font-normal">有钱人</span></span>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="#features" class="hover:text-emerald-600 transition-colors">Features</a>
                <a href="#pricing" class="hover:text-emerald-600 transition-colors">Pricing</a>
                <a href="https://github.com/rizki/youqianren" target="_blank" class="hover:text-emerald-600 transition-colors">Open Source</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('filament.dashboard.pages.dashboard') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-all shadow-md shadow-emerald-500/10 text-sm font-semibold">
                        Open App
                    </a>
                @else
                    @if (Route::has('filament.dashboard.auth.login'))
                        <a href="{{ route('filament.dashboard.auth.login') }}" class="text-sm font-semibold hover:text-emerald-600 transition-colors">Log in</a>
                    @endif

                    @if (Route::has('filament.dashboard.auth.register'))
                        <a href="{{ route('filament.dashboard.auth.register') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-all shadow-md shadow-emerald-500/10 text-sm font-semibold">
                            Get Started
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
