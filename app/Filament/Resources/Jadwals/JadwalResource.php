<?php

namespace App\Filament\Resources\Jadwals;

use App\Filament\Resources\Jadwals\Pages\CreateJadwal;
use App\Filament\Resources\Jadwals\Pages\EditJadwal;
use App\Filament\Resources\Jadwals\Pages\ListJadwals;
use App\Models\Jadwal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

// 
use Filament\Forms\Components;
use Filament\Tables;
use Filament\Schemas;

class JadwalResource extends Resource
{
    protected static ?string $model = Jadwal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $recordTitleAttribute = 'nama_sesi';
    protected static string | \UnitEnum | null $navigationGroup = 'Absensi';
    protected static ?int $navigationSort = 6;
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Schemas\Components\Section::make('Jadwal')
                    ->schema([

                        Components\Select::make('pondok_id')
                            ->relationship('pondok', 'nama')
                            ->required(),

                        Components\Select::make('kategori_id')
                            ->relationship('kategori', 'nama')
                            ->required(),

                        Components\TextInput::make('nama_sesi')
                            ->required(),

                        Components\Select::make('hari')
                            ->options([
                                1 => 'Senin',
                                2 => 'Selasa',
                                3 => 'Rabu',
                                4 => 'Kamis',
                                5 => 'Jumat',
                                6 => 'Sabtu',
                                7 => 'Minggu',
                            ])
                            ->required(),

                        Components\TimePicker::make('jam_mulai')
                            ->seconds(false)
                            ->required(),

                        Components\TimePicker::make('jam_selesai')
                            ->seconds(false)
                            ->required(),

                        Components\Toggle::make('is_active')
                            ->default(true),

                    ])
                    ->columns(2)
                    ->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('nama_sesi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kategori.nama')
                    ->badge(),

                Tables\Columns\TextColumn::make('hari')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu',
                    }),

                Tables\Columns\TextColumn::make('jam_mulai')->dateTime('H:i'),

                Tables\Columns\TextColumn::make('jam_selesai')->dateTime('H:i'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

            ])
            ->defaultSort('hari');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJadwals::route('/'),
            'create' => CreateJadwal::route('/create'),
            'edit' => EditJadwal::route('/{record}/edit'),
        ];
    }
}
