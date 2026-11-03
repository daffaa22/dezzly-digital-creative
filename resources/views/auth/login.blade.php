@extends('layouts.app')

@section('title', 'Login Panel Admin - DEZZLY CREATIVE')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6">

        {{-- Header Card --}}
        <div class="text-center">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-[#0284C7] items-center justify-center font-extrabold text-white text-3xl shadow-lg shadow-sky-600/30 mb-4">
                D
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Masuk ke Panel Admin
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">
                Pusat kendali operasional sewa kamera, inquiry dokumentasi, dan inventaris Dezzly Creative.
            </p>
        </div>

        {{-- Form Card --}}
        <div class="card-clean p-6 sm:p-8 rounded-2xl space-y-6">

            {{-- Error Alert --}}
            @if ($errors->any())
            <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border-2 border-red-300 dark:border-red-700 text-red-800 dark:text-red-300 text-sm flex items-start gap-3">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <strong class="font-bold block">Gagal Masuk:</strong>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">
                        Alamat Email Admin:
                    </label>
                    <input id="email"
                           name="email"
                           type="email"
                           value="{{ old('email', 'admin@dezzlycreative.com') }}"
                           required
                           autofocus
                           placeholder="admin@dezzlycreative.com"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7] dark:focus:border-sky-500">
                </div>

                {{-- Password Field --}}
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-bold text-slate-800 dark:text-slate-200">
                            Kata Sandi (Password):
                        </label>
                    </div>
                    <input id="password"
                           name="password"
                           type="password"
                           required
                           placeholder="••••••••"
                           class="w-full bg-white dark:bg-slate-700 border-2 border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#0284C7] dark:focus:border-sky-500">
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-700 dark:text-slate-300">
                        <input type="checkbox"
                               name="remember"
                               class="w-4 h-4 rounded border-slate-300 text-[#0284C7] focus:ring-[#0284C7]">
                        <span>Ingat saya di komputer ini</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-4 rounded-xl bg-[#0284C7] hover:bg-[#0369A1] text-white font-extrabold text-sm uppercase tracking-wide shadow-md transition-all hover:scale-[1.01] active:scale-[0.99]">
                        Masuk ke Dashboard Admin &rarr;
                    </button>
                </div>
            </form>

            {{-- Kredensial Default Info Box --}}
            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-400 space-y-1">
                <span class="font-extrabold text-slate-800 dark:text-slate-200 block uppercase tracking-wider">Kredensial Bawaan Studio:</span>
                <p>Email: <code class="font-bold text-[#0284C7] dark:text-sky-400">admin@dezzlycreative.com</code></p>
                <p>Kata Sandi: <code class="font-bold text-[#0284C7] dark:text-sky-400">dezzly123</code></p>
            </div>
        </div>

        {{-- Back to Home --}}
        <div class="text-center">
            <a href="{{ route('home') }}" class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-[#0284C7] dark:hover:text-sky-400 transition-colors">
                &larr; Kembali ke Halaman Utama Website
            </a>
        </div>

    </div>
</div>
@endsection
