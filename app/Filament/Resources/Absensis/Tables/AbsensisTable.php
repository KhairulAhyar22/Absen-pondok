<?php

namespace App\Filament\Resources\Absensis\Tables;

use Filament\Actions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AbsensisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->heading('Data Absensi')
            ->columns([
                Tables\Columns\TextColumn::make('kategori.nama')->label('Pengajian')->badge()->color('info')->sortable(),
                Tables\Columns\TextColumn::make('peserta.nama')->label('Peserta')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('jadwal.nama_sesi')->label('Sesi')->sortable(),
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('waktu_scan')->dateTime('H:i')->label('Jam Scan')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'sakit' => 'gray',
                        'izin' => 'warning',
                        'hadir' => 'success',
                        'alfa' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('pondok.nama')->label('Pondok')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                    ])
                    ->default('hadir')
                    ->selectablePlaceholder(false)
                    ->multiple(),

                Tables\Filters\Filter::make('tanggal')
                    ->schema([
                        \Filament\Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                    ])
                    ->query(function (Builder $query, array $data): Builder {

                        return $query->when(
                            $data['tanggal'] ?? null,
                            fn(Builder $query, $tanggal) =>
                            $query->whereDate('tanggal', $tanggal)
                        );
                    }),
                Tables\Filters\SelectFilter::make('kategori')
                    ->relationship('kategori', 'nama')
                    ->searchable()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                Actions\EditAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('absensis.tanggal', 'desc')
            ->filtersTriggerAction(
                fn(\Filament\Actions\Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->deferLoading()
            ->deferFilters(false);
    }
}
