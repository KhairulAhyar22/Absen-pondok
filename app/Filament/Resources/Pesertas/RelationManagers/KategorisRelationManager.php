<?php

namespace App\Filament\Resources\Pesertas\RelationManagers;

use App\Filament\Resources\Kategoris\KategoriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;


class KategorisRelationManager extends RelationManager
{
    protected static string $relationship = 'kategoris';

    protected static ?string $relatedResource = KategoriResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->getStateUsing(fn($record) => $record->pivot->is_active)
                    ->afterStateUpdated(function ($record, $state) {
                        $record->pivot->update([
                            'is_active' => $state,
                        ]);
                    }),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('pivot.prioritas')
                    ->label('Prioritas'),

                Tables\Columns\IconColumn::make('pivot.is_active')
                    ->boolean()
                    ->label('Aktif'),
            ])
            ->headerActions([
                // ...
                Actions\AttachAction::make()
                    ->schema(fn(Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('prioritas')
                            ->numeric()
                            ->required()
                            ->rule(function ($livewire) {

                                return function ($attribute, $value, $fail) use ($livewire) {

                                    $sudahAda = $livewire->ownerRecord
                                        ->kategoris()
                                        ->wherePivot('prioritas', $value)
                                        ->exists();

                                    if ($sudahAda) {
                                        $fail('Prioritas sudah digunakan.');
                                    }
                                };
                            }),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                    ])
                    ->preloadRecordSelect()
                    ->label('Tambah Kategori')
                    ->color('success')
                    ->outlined()
            ])
            ->recordActions([

                Actions\DetachAction::make(),

            ]);
    }
}
