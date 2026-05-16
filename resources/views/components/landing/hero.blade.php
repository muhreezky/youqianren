<header class="relative overflow-hidden pt-20 pb-24 lg:pt-32 lg:pb-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight mb-8 text-slate-900 dark:text-white leading-tight">
            Smart Money Management <br/>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 italic">For Everyone.</span>
        </h1>
        <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-12 leading-relaxed">
            Track income, expenses, and savings with ease. Multi-currency support, custom dashboards, and completely open-source.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            @auth
                <a href="{{ route('filament.dashboard.pages.dashboard') }}" class="px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all shadow-xl shadow-emerald-500/20 text-lg font-bold">
                    Go to Dashboard
                </a>
            @else
                @if (Route::has('filament.dashboard.auth.register'))
                    <a href="{{ route('filament.dashboard.auth.register') }}" class="px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all shadow-xl shadow-emerald-500/20 text-lg font-bold">
                        Create Free Account
                    </a>
                @endif
            @endauth
            <a href="#features" class="px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition-all text-lg font-bold">
                Learn More
            </a>
        </div>
    </div>
    
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 pointer-events-none opacity-20 dark:opacity-10">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-emerald-400 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-teal-400 rounded-full blur-[120px]"></div>
    </div>
</header>
