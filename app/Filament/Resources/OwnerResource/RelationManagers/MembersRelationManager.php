<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\OwnerType;
use App\Enums\OwnerTypeEnum;   
use App\Models\Owner;
use App\Models\Weapon;

use Filament\Tables\Actions\AttachAction;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Form $form): Form
    {
        /**
         * List of Weapons for polsus
         *  - Add Weapon first on weapon tab
         *  - Get List of weapns & assign to member
         */
        $listOwnerWeapons = $this->getOwnerRecord()->weapons()->pluck('name', 'owner_weapons.weapon_id');
        
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_ktp')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                    ])
                    ->required(),   
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('weapons')
                ->label('Assign Senjata')
                ->relationship('weapons', 'name')
                ->options($listOwnerWeapons)
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('gender')
                ->label('Jenis Kelamin')
                ->formatStateUsing(fn(string $state): string => $state == 'male' ? 'Laki-laki' : 'Perempuan'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('weapons.name')
                ->badge()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function(array $data){
                    /**
                     *  Default set to `Individual` member if add member of company
                     */
                    $getOwnerType = OwnerType::where('name', OwnerTypeEnum::INDIVIDUAL->value())->first();
                    return array_merge($data, ['owner_type_id' => $getOwnerType->id]);
                }),
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                //TODO Add weapon to member polsus
                // Tables\Actions\Action::make('Add Weapon')
                // ->form([
                //     Select::make('ownerId')->options(Weapon::all()->pluck('serial', 'id')),
                // ])
                // ->action(fn($record, array $data) => $record->weapons()->attach($data['ownerId']))
               
              
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
