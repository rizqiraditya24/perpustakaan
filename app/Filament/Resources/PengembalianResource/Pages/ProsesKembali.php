<?php

namespace App\Filament\Resources\PengembalianResource\Pages;

use App\Filament\Resources\PengembalianResource;
use App\Models\Peminjaman;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Carbon\Carbon;

class ProsesKembali extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = PengembalianResource::class;
    protected static string $view = 'filament.pages.proses-kembali';

    public ?array $data = [];
    public ?Peminjaman $peminjaman = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('peminjaman_id')
                        ->label('Kode Peminjaman')
                        ->options(fn () => Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])
                            ->with(['siswa.user', 'buku'])
                            ->get()
                            ->mapWithKeys(fn ($p) => [
                                $p->id => $p->kode_peminjaman . ' — ' . $p->siswa->user->nama_lengkap . ' (' . $p->buku->judul . ')'
                            ]))
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (!$state) return;
                            $p = Peminjaman::find($state);
                            if (!$p) return;
                            $aktual    = now();
                            $terlambat = max(0, $p->batas_pengembalian->diffInDays($aktual, false));
                            $set('tanggal_kembali', $aktual->format('Y-m-d'));
                            $set('keterlambatan', $terlambat);
                            $set('denda', $terlambat * 1000);
                            $set('status', $terlambat > 0 ? 'terlambat' : 'dikembalikan');
                        }),
                    DatePicker::make('tanggal_kembali')->required()->default(now())
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $pId = $get('peminjaman_id');
                            if (!$pId || !$state) return;
                            $p = Peminjaman::find($pId);
                            if (!$p) return;
                            $aktual    = Carbon::parse($state);
                            $terlambat = max(0, $p->batas_pengembalian->diffInDays($aktual, false));
                            $set('keterlambatan', $terlambat);
                            $set('denda', $terlambat * 1000);
                            $set('status', $terlambat > 0 ? 'terlambat' : 'dikembalikan');
                        }),
                    TextInput::make('keterlambatan')->numeric()->default(0)->suffix('hari')->readOnly(),
                    TextInput::make('denda')->numeric()->nullable()->prefix('Rp'),
                    Select::make('kondisi_buku')
                        ->options(['baik' => 'Baik', 'rusak' => 'Rusak', 'hilang' => 'Hilang'])
                        ->required()->default('baik'),
                    Select::make('status')
                        ->options([
                            'dikembalikan' => 'Dikembalikan',
                            'terlambat'    => 'Terlambat',
                            'hilang'       => 'Hilang',
                        ])
                        ->required()->default('dikembalikan'),
                    Textarea::make('catatan_pengembalian')->nullable()->columnSpanFull(),
                ])->columns(2),
            ])
            ->statePath('data');
    }

    public function simpan(): void
    {
        $data = $this->form->getState();

        $peminjaman = Peminjaman::findOrFail($data['peminjaman_id']);

        $peminjaman->update([
            'tanggal_kembali'      => $data['tanggal_kembali'],
            'keterlambatan'        => $data['keterlambatan'],
            'denda'                => $data['denda'] ?? 0,
            'kondisi_buku'         => $data['kondisi_buku'],
            'status'               => $data['status'],
            'catatan_pengembalian' => $data['catatan_pengembalian'] ?? null,
        ]);

        // Kembalikan stok buku
        $peminjaman->buku->increment('stok');

        Notification::make()->title('Pengembalian berhasil disimpan')->success()->send();

        $this->redirect(ListPengembalians::getUrl());
    }
}
