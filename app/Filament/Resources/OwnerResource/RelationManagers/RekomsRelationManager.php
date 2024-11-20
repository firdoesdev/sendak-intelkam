<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

use App\Enums\RoleEnum;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Spatie\Permission\Models\Role;

class RekomsRelationManager extends RelationManager
{
    private $is_beladiri; 

    public function __construct()
    {
        $this->is_beladiri = auth()->user()->hasRole(RoleEnum::BELADIRI->value());
    }


    protected static string $relationship = 'rekoms';

    public function form(Form $form): Form
    {
        //Create `Beladiri` Form
        if ($this->is_beladiri) {
            return $form
                ->schema([
                    Forms\Components\TextInput::make('no_rekom')
                        ->required()
                        ->maxLength(255),
                    BelongsToSelect::make('rekom_type_id')
                        ->relationship('rekomType', 'name'),
                    BelongsToSelect::make('role_id')
                        ->relationship('role', 'name')
                        ->default($this->is_beladiri? Role::where('name', 'beladiri')->first()->id : null)
                        ->disabled(true),
                        
                ]);
        }

        return $form;


    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('no_rekom')
            ->columns([
                Tables\Columns\TextColumn::make('no_rekom'),
                Tables\Columns\TextColumn::make('role.name')
                    ->label('Divisi'),
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
