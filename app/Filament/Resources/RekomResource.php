<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekomResource\Pages;
use App\Filament\Resources\RekomResource\RelationManagers;
use App\Models\Rekom;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Spatie\Permission\Models\Role;


class RekomResource extends Resource
{
    protected static ?string $model = Rekom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        dump(auth()->user()->hasRole('super-admin'));
        return $form
            ->schema([
                //
                // Forms\Components\Select::make('role.name')
                // ->relationship('role', 'name')
                // ->options(Role::all()->pluck('name', 'id')->toArray()),

                // Forms\Components\TextInput::make('no_rekom'),
                Section::make([
                    Forms\Components\TextInput::make('title'),
                    Forms\Components\Textarea::make('content'),
                ]),

                Split::make([
                    Section::make([
                        Forms\Components\TextInput::make('title'),
                        Forms\Components\Textarea::make('content'),
                    ])->maxWidth('md'),
                    Section::make([
                        Forms\Components\Toggle::make('is_published'),
                        Forms\Components\Toggle::make('is_featured'),
                    ])->grow(false),
                ])->from('md')

                
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
