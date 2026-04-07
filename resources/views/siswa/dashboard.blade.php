<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Welcome Banner --}}
            <div class="relative bg-blue-600 rounded-3xl shadow-xl overflow-hidden">
                {{-- Decorative Background Elements --}}
                <div class="absolute inset-0 bg-white/5 backdrop-blur-sm"></div>
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-10 rounded-full blur-3xl transform hover:scale-110 transition-transform duration-700"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl transform hover:scale-110 transition-transform duration-700"></div>
                
                <div class="relative px-6 py-10 sm:px-12 sm:py-14 flex flex-col md:flex-row items-center justify-between z-10 gap-8">
                    <div class="text-white max-w-2xl">
                        <h3 class="text-3xl sm:text-4xl font-extrabold mb-3 tracking-tight drop-shadow-md">
                            Selamat datang, <span class="text-blue-100">{{ auth()->user()->nama_lengkap }}!</span> 
                        </h3>
                        <p class="text-white/90 text-lg leading-relaxed">
                            Jelajahi perpustakaan digital kami. 
                            @if($siswa)
                                Anda terdaftar sebagai siswa kelas <span class="font-bold text-white bg-white/20 px-2 py-0.5 rounded shadow-sm">{{ $siswa->kelas }} {{ $siswa->jurusan }}</span> dengan NIS <span class="font-bold text-white bg-white/20 px-2 py-0.5 rounded shadow-sm">{{ $siswa->nis }}</span>.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Action Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                
                {{-- Koleksi Buku --}}
                <a href="{{ route('siswa.koleksi-buku') }}" class="group block relative bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                    <div class="absolute inset-0 bg-blue-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="p-8 relative z-10">
                        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition-colors duration-300">Koleksi Buku</h4>
                        <p class="text-gray-500 text-sm mb-8 leading-relaxed line-clamp-2">Jelajahi berbagai koleksi buku menarik dan temukan bacaan favoritmu untuk dipinjam.</p>
                        
                        <div class="inline-flex items-center text-blue-600 font-bold text-sm bg-blue-50 px-4 py-2 rounded-full group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                            Eksplorasi Sekarang 
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Riwayat Pinjam --}}
                <a href="{{ route('siswa.riwayat-peminjaman') }}" class="group block relative bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                    <div class="absolute inset-0 bg-green-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="p-8 relative z-10">
                        <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-green-600 transition-colors duration-300">Riwayat Pinjam</h4>
                        <p class="text-gray-500 text-sm mb-8 leading-relaxed line-clamp-2">Pantau status buku yang sedang kamu pinjam dan lihat tenggat waktu pengembaliannya.</p>
                        
                        <div class="inline-flex items-center text-green-600 font-bold text-sm bg-green-50 px-4 py-2 rounded-full group-hover:bg-green-600 group-hover:text-white transition duration-300">
                            Lihat Riwayat 
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Profil --}}
                <a href="{{ route('profile.edit') }}" class="group block relative bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                    <div class="absolute inset-0 bg-purple-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="p-8 relative z-10">
                        <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/30 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-purple-600 transition-colors duration-300">Akun Saya</h4>
                        <p class="text-gray-500 text-sm mb-8 leading-relaxed line-clamp-2">Perbarui kata sandi dan amankan kelola preferensi privasi akun Anda dengan mudah.</p>
                        
                        <div class="inline-flex items-center text-purple-600 font-bold text-sm bg-purple-50 px-4 py-2 rounded-full group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                            Atur Profil 
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
