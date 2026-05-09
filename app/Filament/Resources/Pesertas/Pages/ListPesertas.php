<?php

namespace App\Filament\Resources\Pesertas\Pages;

use App\Filament\Resources\Pesertas\PesertaResource;
use App\Models\Peserta;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Kategori;

class ListPesertas extends ListRecords
{
    protected static string $resource = PesertaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [

            'all' => Tab::make('All'),

            'active' => Tab::make('Active')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('is_active', true)
                )
                ->badge(
                    Peserta::where('is_active', true)->count()
                ),

            'inactive' => Tab::make('Inactive')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('is_active', false)
                )
                ->badge(
                    Peserta::where('is_active', false)->count()
                ),

        ];

        foreach (Kategori::all() as $kategori) {

            $tabs['kategori_' . $kategori->id] =

                Tab::make($kategori->nama)

                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas(
                        'kategoris',
                        fn($q) => $q->where('kategoris.id', $kategori->id)
                    )
                )

                ->badge(
                    $kategori->pesertas()->count()
                );
        }

        return $tabs;
    }
}
