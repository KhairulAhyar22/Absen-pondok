<?php

namespace App\Filament\Resources\Pesertas;

use App\Filament\Resources\Pesertas\Pages\CreatePeserta;
use App\Filament\Resources\Pesertas\Pages\EditPeserta;
use App\Filament\Resources\Pesertas\Pages\ListPesertas;
use App\Models\Peserta;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class PesertaResource extends Resource
{
    protected static ?string $model = Peserta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'nama';
    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 4;
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Section::make('Data Peserta')
                    ->schema([
                        Components\Select::make('pondok_id')
                            ->relationship('pondok', 'nama')->searchable()
                            ->preload()->required(),
                        Components\TextInput::make('nama')->required()->maxLength(255),
                        Components\TextInput::make('rfid')->required()->unique(ignoreRecord: true)->maxLength(100),
                        Components\Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                        Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rfid')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('pondok.nama')
                    ->label('Pondok')->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->badge()
                    ->colors([
                        'primary' => 'L',
                        'danger' => 'P',
                    ])->sortable()
                    ->label('L/P'),

                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->sortable()->boolean(),
                Tables\Columns\TextColumn::make('kategoris.nama')
                    ->label('Kategori')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->sortable()->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('pesertas.created_at', 'desc')
            ->filters([
                // nanti bisa ditambahkan filter
            ])
            ->recordActions([
                // Actions\EditAction::make(),
                Actions\ViewAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\KategorisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPesertas::route('/'),
            'create' => CreatePeserta::route('/create'),
            'edit' => EditPeserta::route('/{record}/edit'),
        ];
    }

}
