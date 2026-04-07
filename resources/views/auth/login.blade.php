<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang Kembali!</h2>
        <p class="text-sm text-gray-500 mt-2">Silakan masuk menggunakan email dan password Anda.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Alamat Email" class="font-medium text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white focus:ring-blue-500 focus:border-blue-500 rounded-xl transition duration-200 py-2.5 px-4" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <div class="flex items-center justify-between mb-1">
                <x-input-label for="password" value="Kata Sandi" class="font-medium text-gray-700" />
            </div>
            <div class="relative">
                <x-text-input id="password" class="block w-full bg-gray-50 border-gray-200 focus:bg-white focus:ring-blue-500 focus:border-blue-500 rounded-xl transition duration-200 py-2.5 px-4 pr-12" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••" />
                
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" tabindex="-1">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="show" x-cloak style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 w-4 h-4 cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition">Ingat sesi saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm border-blue-600 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                Masuk Sekarang
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 hover:underline transition duration-150">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
