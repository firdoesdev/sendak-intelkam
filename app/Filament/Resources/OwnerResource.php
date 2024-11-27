<?php

namespace App\Filament\Resources;

use App\Enums\OwnerTypeEnum;
use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers\WeaponsRelationManager;
use App\Models\Owner;
use App\Models\OwnerType;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OwnerResource\RelationManagers\RekomsRelationManager;
use App\Services\RekomServices\CommonRekomService;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {   
        return parent::getEloquentQuery()
        ->with(['rekoms'])
        ->whereHas('rekoms', function ($query) {    
            $rekoms = new CommonRekomService();
            return$query->where('role_id', $rekoms->getRekomRoleId());
        });
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
                            ->label('Nomor KTP')
                            ->numeric()
                            ->placeholder('ex: 9999999999999999')
                            ->required(),

                            TextInput::make('address')
                            ->label('Alamat')
                            ->placeholder('ex: Jalan Raya No. 1')
                            ->required(),

                            TextInput::make('phone')
                            ->label('Nomor Telepon')
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
                Tables\Columns\TextColumn::make('no_ktp')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('address')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('rekoms.no_rekom')
                ->label('No Rekom'),
                Tables\Columns\TextColumn::make('rekoms.activated_at')
                ->label('Tanggal Rekom Terbit')
                ->date(),               
                Tables\Columns\TextColumn::make('rekoms.expired_at')
                ->label('Tanggal Rekom Terbit')
                ->date(),               
                Tables\Columns\TextColumn::make('rekoms.role.name')
                ->label('Divisi')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('Ubah'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
