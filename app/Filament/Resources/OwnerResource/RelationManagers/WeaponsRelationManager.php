<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

use App\Models\OwnerWeapon;
use App\Models\Owner;
use App\Models\Weapon;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use App\Enums\OwnerTypeEnum;

class WeaponsRelationManager extends RelationManager
{
    protected static string $relationship = 'weapons';
    protected static ?string $title = 'Senjata';

    public function form(Form $form): Form
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

                Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Aktif',
                    'inactive' => 'Tidak Aktif',
                ])
                ->label('Status'),

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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('serial')
            ->columns([
                Tables\Columns\TextColumn::make('serial')->label('Nomor Seri')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('weaponType.name')->label('Jenis Senjata'),
                Tables\Columns\TextColumn::make('caliber')->label('Kaliber'),
                Tables\Columns\TextColumn::make('warehouse.name')->label('Gudang'),
                Tables\Columns\SelectColumn::make('status')
                ->options([
                    'active' => 'Aktif',
                    'inactive' => 'Tidak Aktif',
                ])
                ->label('Status'),
                Tables\Columns\TextColumn::make('description')->label('Keterangan'),
                Tables\Columns\TextColumn::make('owners')
                ->getStateUsing(fn (Weapon $record): string => $record->owners->where('parent_id','!=', null)->pluck('name')->implode(', '))
                ->label('Member'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Buat Senjata Baru'),
                Tables\Actions\AttachAction::make()
                ->label('Pilih Senjata')
                ->form(fn(AttachAction $action) => [
                    $action->getRecordSelect()->label('Nomor Seri'),
                    Select::make('description')->label('Status')->options([
                        'Baru' => 'Baru',
                        'Hibah' => 'Hibah',
                    ])
                    ->required()
                    ->live(),
                    Select::make('previous_owner_id')
                    ->label('Pemilik Senjata sebelumnya')
                    ->options(Owner::whereHas('OwnerType', function($query){
                        $query->where('name', OwnerTypeEnum::INDIVIDUAL->value());
                    })->pluck('name', 'id'))
                    ->visible(fn(Get $get) => $get('description')),  
                ])
                
                /* TODO after attach
                 - for default set status `active` when attaced
                 - set all previous ownership status to 'inactive'

                */
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
