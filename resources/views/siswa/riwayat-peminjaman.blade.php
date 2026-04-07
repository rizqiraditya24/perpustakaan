<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Peminjaman</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">Riwayat Peminjaman Saya</h3>
                </div>

                @if($peminjaman->isEmpty())
                    <div class="p-10 text-center text-gray-500">Belum ada riwayat peminjaman.</div>
                @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batas Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($peminjaman as $p)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->kode_peminjaman }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-semibold">{{ $p->buku->judul }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $p->tanggal_pinjam->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $p->batas_pengembalian->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $colors = [
                                        'dipinjam'     => 'bg-yellow-100 text-yellow-800',
                                        'dikembalikan' => 'bg-green-100 text-green-800',
                                        'terlambat'    => 'bg-red-100 text-red-800',
                                        'hilang'       => 'bg-gray-100 text-gray-800',
                                    ];
                                    $labels = [
                                        'dipinjam'     => 'DIPINJAM',
                                        'dikembalikan' => 'DIKEMBALIKAN',
                                        'terlambat'    => 'TERLAMBAT',
                                        'hilang'       => 'HILANG',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $labels[$p->status] ?? $p->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
