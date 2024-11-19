<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekomResource\Pages;

use App\Models\Rekom;

use Filament\Forms\Form;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Filament\Resources\RekomResource\Forms\BeladiriFrom;


class RekomResource extends Resource
{
    protected static ?string $model = Rekom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldSkipAuthorization = true;

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        // dump($user);

       if($user->hasRole('beladiri')){
        return $form
            ->schema(BeladiriFrom::getSchema());
       }

        
        return $form;
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('owner.name')->label('Pemilik'),
                Tables\Columns\TextColumn::make('owner.weapons'),
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
            'index' => Pages\ListRekoms::route('/'),
            'create' => Pages\CreateRekom::route('/create'),
            'edit' => Pages\EditRekom::route('/{record}/edit'),
        ];
    }
}
