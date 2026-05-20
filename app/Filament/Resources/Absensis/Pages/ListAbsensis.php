<?php

namespace App\Filament\Resources\Absensis\Pages;

use App\Filament\Resources\Absensis\AbsensiResource;
use App\Filament\Resources\Absensis\Widgets;
use App\Filament\Resources\Absensis\Widgets\AbsensiOverview;
use App\Models\Absensi;
use App\Models\Kategori;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    public ?string $hariFilter = null;

    use ExposesTableToWidgets;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AbsensiOverview::class,
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        foreach (
            Kategori::where('is_active', true)
                // ->limit(5)
                ->get() as $kategori
        ) {

            $tabs['kategori_' . $kategori->id] =

                Tab::make($kategori->nama)

                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('kategori_id', $kategori->id)
                )

                ->badge(
                    Absensi::query()
                        ->where('kategori_id', $kategori->id)
                        // ->whereDate('tanggal', today())
                        ->count()
                );
        }

        return $tabs;
    }
}
