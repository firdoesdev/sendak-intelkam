<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeaponsRelationManager extends RelationManager
{
    protected static string $relationship = 'weapons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('serial')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('caliber')
                    ->required()
                    ->maxLength(255),

                    BelongsToSelect::make('weapon_type_id')
                    ->searchable()
                    ->relationship('weaponType', 'name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('serial')
            ->columns([
                Tables\Columns\TextColumn::make('serial')->label('Nomor Seri')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('weaponType.name')->label('Jenis Senjata'),
                Tables\Columns\TextColumn::make('caliber')->label('Kaliber'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}