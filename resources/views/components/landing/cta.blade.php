<section class="py-24 bg-emerald-600 text-white overflow-hidden relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-4xl lg:text-5xl font-bold mb-8 italic tracking-tight">Ready to master your wealth?</h2>
        @auth
            <a href="{{ route('filament.dashboard.pages.dashboard') }}" class="inline-block px-12 py-5 bg-white text-emerald-600 rounded-2xl font-bold text-xl hover:scale-105 transition-transform shadow-2xl">
                Open Dashboard
            </a>
        @else
            @if (Route::has('filament.dashboard.auth.register'))
                <a href="{{ route('filament.dashboard.auth.register') }}" class="inline-block px-12 py-5 bg-white text-emerald-600 rounded-2xl font-bold text-xl hover:scale-105 transition-transform shadow-2xl">
                    Create Your Free Account
                </a>
            @endif
        @endauth
    </div>
    <!-- Decorative circles -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-emerald-500 rounded-full -translate-x-1/2 -translate-y-1/2 opacity-50"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-700 rounded-full translate-x-1/3 translate-y-1/3 opacity-30"></div>
</section>
