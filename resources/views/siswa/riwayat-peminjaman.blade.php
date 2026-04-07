<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Riwayat Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-white flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Aktivitas Pinjaman</h3>
                        <p class="text-sm text-gray-500 mt-1">Daftar semua buku yang sedang dan pernah Anda pinjam.</p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                @if($peminjaman->isEmpty())
                    <div class="p-16 text-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5 text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Riwayat</h4>
                        <p class="text-gray-500 max-w-md mx-auto">Anda belum pernah meminjam buku. Silakan kunjungi halaman Koleksi Buku untuk mulai meminjam bacaan favorit Anda.</p>
                        <a href="{{ route('siswa.koleksi-buku') }}" class="inline-flex items-center gap-2 mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition duration-300 shadow-sm shadow-blue-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            Lihat Koleksi Buku
                        </a>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/70 border-b border-gray-100">
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Informasi Buku</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">KODE TRX</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Batas Kembali</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($peminjaman as $p)
                            <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-20 bg-gray-100 rounded-lg border border-gray-200 overflow-hidden flex-shrink-0 shadow-sm">
                                            @if($p->buku->cover_image)
                                                <img src="{{ Storage::disk('public')->url($p->buku->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-50">
                                                    <svg class="w-6 h-6 leading-none mb-1 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <span class="text-[8px] font-bold uppercase">No Cover</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 line-clamp-2 max-w-xs leading-tight mb-1">{{ $p->buku->judul }}</p>
                                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ $p->buku->penulis }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-mono font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                        {{ $p->kode_peminjaman }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center text-sm font-medium text-gray-600 gap-2">
                                        <div class="p-1.5 bg-gray-50 rounded-md">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        {{ $p->tanggal_pinjam->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center text-sm font-bold {{ $p->status === 'terlambat' ? 'text-red-600' : 'text-gray-900' }} gap-2">
                                        <div class="p-1.5 {{ $p->status === 'terlambat' ? 'bg-red-50 text-red-500' : 'bg-gray-50 text-gray-400' }} rounded-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        {{ $p->batas_pengembalian->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @php
                                        $colors = [
                                            'dipinjam'     => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                            'dikembalikan' => 'bg-green-50 text-green-700 border-green-200',
                                            'terlambat'    => 'bg-red-50 text-red-700 border-red-200',
                                            'hilang'       => 'bg-gray-50 text-gray-700 border-gray-200',
                                        ];
                                        $labels = [
                                            'dipinjam'     => 'Dipinjam',
                                            'dikembalikan' => 'Dikembalikan',
                                            'terlambat'    => 'Terlambat',
                                            'hilang'       => 'Hilang',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold border shadow-sm {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        @if($p->status === 'dipinjam')
                                            <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2 shadow-sm shadow-yellow-500/50"></span>
                                        @elseif($p->status === 'dikembalikan')
                                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2 shadow-sm shadow-green-500/50"></span>
                                        @elseif($p->status === 'terlambat')
                                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse shadow-sm shadow-red-500/50"></span>
                                        @endif
                                        {{ $labels[$p->status] ?? ucfirst($p->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
