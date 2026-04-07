<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Koleksi Buku</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Koleksi Buku</h3>
                        <p class="text-sm text-gray-500">Pilih buku yang ingin Anda pinjam dari daftar di bawah.</p>
                    </div>
                    {{-- Filter Kategori --}}
                    <form method="GET" action="{{ route('siswa.koleksi-buku') }}">
                        <select name="kategori_id" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if($bukus->isEmpty())
                    <p class="text-center text-gray-500 py-10">Tidak ada buku tersedia.</p>
                @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($bukus as $buku)
                    <div class="flex flex-col bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                        {{-- Cover --}}
                        <div class="relative">
                            @if($buku->cover_image)
                                <img src="{{ Storage::disk('public')->url($buku->cover_image) }}" alt="{{ $buku->judul }}" class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-44 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">NO COVER</span>
                                </div>
                            @endif
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-0.5 rounded">
                                Tersedia {{ $buku->stok }}
                            </span>
                        </div>

                        {{-- Info --}}
                        <div class="p-3 flex flex-col flex-1">
                            <p class="font-semibold text-sm text-gray-800 leading-tight mb-1">{{ $buku->judul }}</p>
                            <p class="text-xs text-gray-500">{{ $buku->penulis }}</p>
                            <p class="text-xs text-gray-400 mb-2">
                                {{ $buku->kategoris->pluck('nama_kategori')->join(', ') ?: '-' }}
                            </p>
                            <div class="mt-auto">
                                <form method="POST" action="{{ route('siswa.pinjam', $buku) }}">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 rounded">
                                        PINJAM
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
    </div>
</x-app-layout>
