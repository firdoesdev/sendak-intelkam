<?php

namespace App\Filament\Resources;

use App\Enums\OwnerTypeEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Filament\Resources\OwnerResource\RelationManagers\WeaponsRelationManager;
use App\Models\Owner;
use Spatie\Permission\Models\Role;
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

use App\Services\RekomServices\RekomsService;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {   
        // return parent::getEloquentQuery()
        // ->with(['rekoms'])
        // ->whereHas('rekoms', function ($query) {    
        //     $rekoms = new RekomsService();
        //     return$query->where('role_id', $rekoms->rekomDivision());
        // });
        return parent::getEloquentQuery();
        
    }
    

    public static function form(Form $form): Form
    {

        $defaultOwnerTypeId = OwnerType::where('name', OwnerTypeEnum::INDIVIDUAL->value())->first()->id;

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
                            
                            TextInput::make('name')
                            ->placeholder('ex: John Doe')
                            ->required(),
                            
                            TextInput::make('no_ktp')
                            ->numeric()
                            ->placeholder('ex: 9999999999999999')
                            ->required(),

                            TextInput::make('address')
                            ->placeholder('ex: Jalan Raya No. 1')
                            ->required(),
                            TextInput::make('phone')
                            ->placeholder('ex: 08123456789')
                            ->numeric()
                            ->required(),
                            
                        ]),



                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('rekoms.activitated_at')
                ->label('Tanggal Rekom Terbit')
                ->date(),
                Tables\Columns\TextColumn::make('rekoms.no_rekom')
                ->badge(),
                Tables\Columns\TextColumn::make('weapons.serial')
                ->label('Seri Senjata')
                ->badge(),

                Tables\Columns\TextColumn::make('rekoms.role.name')
                ->label('Divisi')
                ->badge()

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
