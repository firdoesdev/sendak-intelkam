<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekomTypeResource\Pages;
use App\Filament\Resources\RekomTypeResource\RelationManagers;
use App\Models\RekomType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekomTypeResource extends Resource
{
    protected static ?string $model = RekomType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $slug = 'master-data/rekom-types';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRekomTypes::route('/'),
            'create' => Pages\CreateRekomType::route('/create'),
            'edit' => Pages\EditRekomType::route('/{record}/edit'),
        ];
    }
}
