<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekomResource\Pages;
use App\Filament\Resources\RekomResource\RelationManagers;
use App\Models\Rekom;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Spatie\Permission\Models\Role;


class RekomResource extends Resource
{
    protected static ?string $model = Rekom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldSkipAuthorization = true;

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        // dump(auth()->user()->hasRole('super-admin'));
        return $form
            ->schema([
                Grid::make(12)
                ->schema([
                    Group::make([
                        BelongsToSelect::make('owner_type_id')
                        ->relationship('ownerType', 'name')
                        ->required()
                        ->disabled($user->hasRole('super-admin') ? true : false)
                    ])
                    ->relationship('owner')
                    ->columnSpan(6),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('role.name')->label('Division'),
                Tables\Columns\TextColumn::make('no_rekom'),
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