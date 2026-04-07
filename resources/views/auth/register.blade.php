<x-guest-layout maxWidth="sm:max-w-3xl">
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-2">Lengkapi formulir di bawah ini untuk menjadi anggota perpustakaan.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-8">
        @csrf

        {{-- Data Akun --}}
        <div>
            <div class="flex items-center gap-2 mb-4 text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <h3 class="text-sm font-bold uppercase tracking-wider">Kredensial Login</h3>
            </div>
            
            <div class="bg-gray-50/80 p-5 rounded-2xl border border-gray-100 space-y-4 shadow-inner">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nama_lengkap" value="Nama Lengkap" class="font-medium text-gray-700" />
                        <x-text-input id="nama_lengkap" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required autofocus placeholder="John Doe" />
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="username" value="Username" class="font-medium text-gray-700" />
                        <x-text-input id="username" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4" type="text" name="username" :value="old('username')" required placeholder="johndoe123" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="email" value="Alamat Email" class="font-medium text-gray-700" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="john@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div x-data="{ show: false }">
                        <x-input-label for="password" value="Kata Sandi" class="font-medium text-gray-700" />
                        <div class="relative mt-1">
                            <x-text-input id="password" class="block w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4 pr-12" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="••••••••" />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" tabindex="-1">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="show" x-cloak style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div x-data="{ show: false }">
                        <x-input-label for="password_confirmation" value="Konfirmasi Sandi" class="font-medium text-gray-700" />
                        <div class="relative mt-1">
                            <x-text-input id="password_confirmation" class="block w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4 pr-12" x-bind:type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" tabindex="-1">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="show" x-cloak style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Identitas --}}
        <div>
            <div class="flex items-center gap-2 mb-4 text-blue-600 mt-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                <h3 class="text-sm font-bold uppercase tracking-wider">Data Diri & Siswa</h3>
            </div>
            
            <div class="bg-gray-50/80 p-5 rounded-2xl border border-gray-100 space-y-4 shadow-inner">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nis" value="Nomor Induk Siswa (NIS)" class="font-medium text-gray-700" />
                        <x-text-input id="nis" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4" type="text" name="nis" :value="old('nis')" required placeholder="Contoh: 12345" />
                        <x-input-error :messages="$errors->get('nis')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="font-medium text-gray-700" />
                        <x-text-input id="tanggal_lahir" class="block mt-1 w-full rounded-xl border-gray-200 text-gray-600 py-2.5 px-4" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" />
                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="kelas" value="Kelas" class="font-medium text-gray-700" />
                        <x-text-input id="kelas" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4" type="text" name="kelas" :value="old('kelas')" required placeholder="Contoh: X, XI, XII" />
                        <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="jurusan" value="Jurusan" class="font-medium text-gray-700" />
                        <x-text-input id="jurusan" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4" type="text" name="jurusan" :value="old('jurusan')" placeholder="Contoh: IPA, IPS" />
                        <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="telepon" value="Nomor WhatsApp/Telepon" class="font-medium text-gray-700" />
                        <x-text-input id="telepon" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4" type="text" name="telepon" :value="old('telepon')" placeholder="0812xxxxxxxx" />
                        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat" value="Alamat Domisili" class="font-medium text-gray-700" />
                        <x-text-input id="alamat" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-blue-500 py-2.5 px-4" type="text" name="alamat" :value="old('alamat')" placeholder="Jl. Raya No. 1" />
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                Selesaikan Pendaftaran
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 hover:underline transition duration-150">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
