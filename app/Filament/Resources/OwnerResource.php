<?php

namespace App\Filament\Resources;

use App\Enums\OwnerTypeEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Filament\Resources\OwnerResource\RelationManagers\WeaponsRelationManager;
use App\Models\Owner;
use App\Models\OwnerType;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Filament\Resources\OwnerResource\RelationManagers\RekomsRelationManager;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            // ...
        ]);
}

    public static function form(Form $form): Form
    {

        $defaultOwnerTypeId = OwnerType::where('name', OwnerTypeEnum::INDIVIDUAL->value())->first()->id;
        // dump($defaultOwnerType);

        return $form
            ->schema([
                Fieldset::make('Data Kepemilikan')
                        ->columnSpan(8)
                        ->schema([

                            BelongsToSelect::make('ownerType')
                            ->label('Jenis Kepemilikan')
                            ->relationship('ownerType', 'name')
                            ->default($defaultOwnerTypeId)
                            ->disabled()
                            ->required()
                            ->hidden(),
                            
                            TextInput::make('name')->required(),
                            TextInput::make('no_ktp')->required(),
                            TextInput::make('address')->required(),
                            TextInput::make('phone')->required(),
                            
                        ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                // Tables\Columns\Column::make('name')
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('address'),

            ])
            ->filters([
                //
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
            RekomsRelationManager::class,
            WeaponsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
