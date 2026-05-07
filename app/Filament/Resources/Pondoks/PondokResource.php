<?php

namespace App\Filament\Resources\Pondoks;

use App\Filament\Resources\Pondoks\Pages\CreatePondok;
use App\Filament\Resources\Pondoks\Pages\EditPondok;
use App\Filament\Resources\Pondoks\Pages\ListPondoks;
use App\Filament\Resources\Pondoks\Schemas\PondokForm;
use App\Filament\Resources\Pondoks\Tables\PondoksTable;
use App\Models\Pondok;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
// 
use Filament\Forms\Components;
use Filament\Tables;
use Filament\Actions;
use UnitEnum;
use Filament\Schemas;

class PondokResource extends Resource
{
    protected static ?string $model = Pondok::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;
    // Tambahan
    protected static ?string $navigationLabel = 'Pondok';
    protected static ?string $modelLabel = 'Pondok';
    protected static ?string $pluralModelLabel = 'Data Pondok';
    // protected static ?string $recordTitleAttribute = 'nama';
    
    // protected static string | UnitEnum | null $navigationGroup = 'Pondok';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        // return PondokForm::configure($schema);
        return $schema
            ->schema([
                Schemas\Components\Section::make('Data Pondok')
                    ->schema([
                        Components\TextInput::make('nama')->required()->maxLength(255),
                        Components\TextInput::make('kode')->required()->unique(ignoreRecord: true)->maxLength(50),
                        Components\Textarea::make('alamat')->rows(3),
                        Components\TextInput::make('telepon')->tel()->maxLength(20),
                        Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    ])->columns(2)->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kode')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('telepon')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->sortable()->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->sortable()->label('Dibuat'),
            ])
            ->filters([
                // nanti bisa ditambahkan filter
            ])
            ->recordActions([
                Actions\EditAction::make(),
                // Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPondoks::route('/'),
            'create' => CreatePondok::route('/create'),
            'edit' => EditPondok::route('/{record}/edit'),
        ];
    }
}
