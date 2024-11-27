<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeaponResource\Pages;
use App\Filament\Resources\WeaponResource\RelationManagers;
use App\Models\Weapon;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\BelongsToSelect;

class WeaponResource extends Resource
{
    protected static ?string $model = Weapon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('serial')
                    ->label('Seri Senjata')
                    ->required()
                    ->maxLength(255),
                    
                    Forms\Components\TextInput::make('name')
                    ->label('Nama Senjata')
                    ->required()
                    ->maxLength(255),

                    Forms\Components\TextInput::make('caliber')
                    ->label('Kaliber')
                    ->required()
                    ->maxLength(255),

                    Forms\Components\TextInput::make('brand')
                    ->label('Merk / Brand')
                    ->required()
                    ->maxLength(255),

                    BelongsToSelect::make('weapon_type_id')
                    ->label('Jenis Senjata')
                    ->searchable()
                    ->relationship('weaponType', 'name'),

                    BelongsToSelect::make('warehouse_id')
                    ->label('Gudang')
                    ->searchable()
                    ->relationship('warehouse', 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('serial')->searchable(),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('caliber'),
                Tables\Columns\TextColumn::make('weaponType.name'),
                Tables\Columns\TextColumn::make('warehouse.name')
                ->searchable()
                ->label('Lokasi Gudang'),
            ])
            ->filters([
                //
            ])
            ->groups([
                'warehouse.name',
                'weaponType.name',
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\OwnersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeapons::route('/'),
            'create' => Pages\CreateWeapon::route('/create'),
            'edit' => Pages\EditWeapon::route('/{record}/edit'),
        ];
    }
}
