<section id="pricing" class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4 tracking-tight">Transparent Options</h2>
            <p class="text-slate-600 dark:text-slate-400">Total control or total convenience. You choose.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- Self Hosted -->
            <div class="p-10 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col">
                <h3 class="text-2xl font-bold mb-2 tracking-tight">Self-Hosted</h3>
                <div class="text-5xl font-black mb-6">$0</div>
                <p class="text-slate-600 dark:text-slate-400 mb-8 flex-grow leading-relaxed">Complete freedom. Host it on your own server, manage your own data.</p>
                <ul class="space-y-4 mb-10 text-sm font-medium">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Full Source Code Access
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        No User Limits
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Own Your Data
                    </li>
                </ul>
                <a href="https://github.com/rizki/youqianren" target="_blank" class="w-full py-4 text-center border border-slate-200 dark:border-slate-700 rounded-2xl font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    GitHub Repository
                </a>
            </div>

            <!-- Cloud -->
            <div class="p-10 rounded-3xl bg-slate-900 text-white shadow-2xl shadow-emerald-500/20 flex flex-col relative overflow-hidden">
                <div class="absolute top-0 right-0 px-6 py-2 bg-emerald-500 text-xs font-bold uppercase tracking-widest rounded-bl-3xl">Managed</div>
                <h3 class="text-2xl font-bold mb-2 tracking-tight">Cloud Version</h3>
                <div class="text-5xl font-black mb-6">$5<span class="text-lg font-normal opacity-60">/mo</span></div>
                <p class="opacity-70 mb-8 flex-grow leading-relaxed">Let us handle the technical stuff so you can focus on your finances.</p>
                <ul class="space-y-4 mb-10 text-sm font-medium">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Automatic Daily Backups
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Priority Security Updates
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        1-Click Setup
                    </li>
                </ul>
                @auth
                    <a href="{{ route('filament.dashboard.pages.dashboard') }}" class="w-full py-4 text-center bg-emerald-600 rounded-2xl font-bold hover:bg-emerald-500 transition-colors shadow-lg shadow-emerald-500/40">
                        Go to App
                    </a>
                @else
                    @if (Route::has('filament.dashboard.auth.register'))
                        <a href="{{ route('filament.dashboard.auth.register') }}" class="w-full py-4 text-center bg-emerald-600 rounded-2xl font-bold hover:bg-emerald-500 transition-colors shadow-lg shadow-emerald-500/40">
                            Start 14-Day Free Trial
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</section>
