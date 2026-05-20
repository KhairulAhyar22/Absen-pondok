<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Forms\Components\TextInput;
// MODEL
use App\Models\Peserta;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Kategori;
// 

class ScanRfid extends Page implements HasSchemas
{
    use InteractsWithSchemas;
    protected string $view = 'filament.pages.scan-rfid';

    protected static ?string $slug = 'sambung/absen';
    protected static string $layout = 'filament.layouts.blank';
    protected ?string $heading = '';

    // PROPERTY
    public ?array $data = [];
    public ?Kategori $kategori = null;

    public function mount(): void
    {
        $this->resetForm();

        $this->kategori = Kategori::query()
            ->where('is_active', true)
            ->first();

        if (! $this->kategori) {

            $this->notify(
                'error',
                'Kategori aktif tidak ditemukan'
            );
        }
    }

    // FORM
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('rfid')
                    ->label('')
                    ->placeholder('Tempelkan kartu...')
                    ->required()
                    ->autofocus()
                    ->extraInputAttributes([
                        'id' => 'rfid-input',
                        'autocomplete' => 'off',
                    ])
            ])
            ->statePath('data');
    }

    // LOGIC PROSES SCAN
    public function prosesScan(): void
    {
        $rfid = trim($this->data['rfid'] ?? '');
        if ($rfid === '') {
            $this->notify('warning', 'RFID kosong');
            $this->resetFormAndRefresh();
            return;
        }

        $peserta = Peserta::query()
            ->where('rfid', $rfid)
            ->where('is_active', true)
            ->first();

        if (! $peserta) {
            $this->notify('error', 'Peserta tidak terdaftar');
            $this->resetFormAndRefresh();
            return;
        }

        // CEK PRIORITAS SAMBUNG JIKA SAMBUNG PESERTA ADA 2 SEKALIGUS
        $kategoriPeserta = $peserta->kategoris()

            ->wherePivot('is_active', true)
            ->orderByPivot('prioritas')
            ->get();

        // CEK JADWAL

        $jadwal = null;

        $kategoriDipakai = null;

        foreach ($kategoriPeserta as $kategori) {

            $jadwalAktif = Jadwal::query()

                ->where('kategori_id', $kategori->id)

                ->where('is_active', true)

                ->where('hari', now()->dayOfWeekIso)

                ->whereTime('jam_mulai', '<=', now()->format('H:i:s'))

                ->whereTime('jam_selesai', '>=', now()->format('H:i:s'))

                ->first();

            if ($jadwalAktif) {

                $jadwal = $jadwalAktif;

                $kategoriDipakai = $kategori;

                break;
            }
        }

        if (! $jadwal) {

            $this->notify('info', 'Tidak ada pengajian berlangsung');

            $this->resetFormAndRefresh();

            return;
        }

        $sudahAbsen = Absensi::query()

            ->where('peserta_id', $peserta->id)
            ->where('jadwal_id', $jadwal->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            $this->notify('warning', 'Peserta sudah absen');
            $this->resetFormAndRefresh();
            return;
        }

        Absensi::create([

            'pondok_id' => $peserta->pondok_id,

            'peserta_id' => $peserta->id,

            'kategori_id' => $kategoriDipakai->id,

            'jadwal_id' => $jadwal->id,

            'tanggal' => today(),

            'waktu_scan' => now(),

            'status' => 'hadir',

        ]);

        $this->notify('success', 'Absensi berhasil');

        $this->resetFormAndRefresh();

        return;
    }
    public function resetForm(): void
    {
        $this->form->fill([
            'rfid' => '',
        ]);
    }
    public function resetFormAndRefresh(): void
    {
        $this->resetForm();

        // kirim event ke frontend untuk reload UI
        $this->dispatch('scan-finished');
    }
    public function notify(string $type, string $message): void
    {
        $this->dispatch('notify', type: $type, message: $message);
    }
}
