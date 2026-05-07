<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Section::make('Data Pengguna')
                    // ->description('Silakan isi data pondok')
                    // ->icon('heroicon-o-building-office')

                    ->schema([
                        Components\TextInput::make('name')->required()->maxLength(255)->label('Nama Admin'),
                        Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                        Components\Select::make('pondok_id')->relationship('pondok', 'nama')->searchable()->preload(),
                        Components\Select::make('peran')
                            ->options([
                                'super_admin' => 'Super Admin',
                                'admin_pondok' => 'Admin Pondok',
                            ])
                            ->required(),
                        Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->required(fn(string $operation) => $operation === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => bcrypt($state)),

                        Components\Toggle::make('is_active')
                            ->label('Aktif')
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

                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('pondok.nama')->label('Pondok')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('peran')->sortable()
                    ->colors([
                        'danger' => 'super_admin',
                        'success' => 'admin_pondok',
                    ]),
                Tables\Columns\IconColumn::make('is_active')->searchable()
                    ->label('Aktif')
                    ->boolean(),

            ])
            ->recordActions([
                Actions\EditAction::make(),
                // Actions\ViewAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')->searchable();
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
