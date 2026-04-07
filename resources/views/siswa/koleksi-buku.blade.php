<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Koleksi Buku') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Header/Banner --}}
            <div class="relative bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Eksplorasi Perpustakaan</h3>
                    <p class="text-gray-500">Temukan buku-buku menarik dari berbagai kategori untuk menambah wawasanmu.</p>
                </div>
                
                <form method="GET" action="{{ route('siswa.koleksi-buku') }}" class="w-full md:w-auto relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </div>
                    <select name="kategori_id" onchange="this.form.submit()" class="pl-12 pr-10 py-3 w-full md:w-64 bg-gray-50 border-gray-200 text-gray-700 font-medium rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 transition-colors cursor-pointer appearance-none">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </form>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <div class="bg-green-100 p-2 rounded-full">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <span class="block font-bold text-sm">Berhasil!</span>
                        <span class="block text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <div class="bg-red-100 p-2 rounded-full">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <span class="block font-bold text-sm">Gagal!</span>
                        <span class="block text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if($bukus->isEmpty())
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Buku Tersedia</h3>
                    <p class="text-gray-500 max-w-sm mx-auto shadow-none">Buku untuk kategori ini sedang kosong atau belum ditambahkan oleh Admin perpustakaan.</p>
                </div>
            @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($bukus as $buku)
                <div class="group bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border border-gray-100 flex flex-col h-full">
                    {{-- Cover --}}
                    <div class="relative w-full shrink-0 aspect-[3/4] bg-gray-50 overflow-hidden">
                        @if($buku->cover_image)
                            <img src="{{ Storage::disk('public')->url($buku->cover_image) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-100">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">No Cover</span>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/90 backdrop-blur-sm text-green-700 font-bold text-xs px-2.5 py-1 rounded-lg border border-green-200 shadow-sm flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Stok: {{ $buku->stok }}
                            </span>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="mb-4 flex-grow">
                            <h4 class="font-bold text-gray-900 leading-tight mb-2 line-clamp-2">{{ $buku->judul }}</h4>
                            <p class="text-sm text-gray-500 mb-3 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span class="line-clamp-1">{{ $buku->penulis }}</span>
                            </p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($buku->kategoris as $kategori)
                                    <span class="inline-block bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-bold px-2 py-1 rounded-lg">
                                        {{ $kategori->nama_kategori }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <form method="POST" action="{{ route('siswa.pinjam', $buku) }}">
                                @csrf
                                <button type="submit" class="w-full bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white text-sm font-bold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 group/btn">
                                    <svg class="w-5 h-5 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Pinjam Buku
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
