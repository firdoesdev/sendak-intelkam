<?php

namespace App\Filament\Resources;

use App\Enums\RekomStatusEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\RekomResource\Pages;

use App\Filament\Resources\RekomResource\RelationManagers\OwnerRelationManager;
use App\Models\Rekom;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Filament\Resources\RekomResource\Forms\BeladiriFrom;

use App\Services\RekomServices\CommonRekomService;
use Str;

class RekomResource extends Resource
{
    protected static ?string $model = Rekom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldSkipAuthorization = true;

    public static function getEloquentQuery(): Builder
    {
        // $rekoms = new CommonRekomService();
        // return parent::getEloquentQuery()->where('role_id', $rekoms->getRekomRoleId());
        
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Detail Rekom')
            ->schema([
                TextInput::make('no_rekom'),
                Select::make('status')
                ->options([
                    RekomStatusEnum::ACTIVE->value() => RekomStatusEnum::ACTIVE->label(),
                    RekomStatusEnum::EXPIRED->value() => RekomStatusEnum::EXPIRED->label(),
                    RekomStatusEnum::EXPIRED_SOON->value() => RekomStatusEnum::EXPIRED_SOON->label(),
                    RekomStatusEnum::DRAFT->value() => RekomStatusEnum::DRAFT->label()
                ]),
                DatePicker::make('activated_at')
                ->label('Tgl Rekom Terbit'),
                DatePicker::make('expired_at')
                ->label('Tgl Kadaluarsa'),
            ])
        ]);

        

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('no_rekom')->label('No Rekom')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('activated_at')
                    ->label('Tgl Rekom Terbit')
                    ->date(),
                Tables\Columns\TextColumn::make('expired_at')
                    ->label('Tgl Rekom Kadaluarsa')
                    ->date(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'expired',
                        'warning' => 'draft'
                    ])
                    ->icons([
                        'heroicon-s-check-circle' => 'active',
                        'heroicon-s-x-circle' => 'expired',
                        'heroicon-s-question-mark-circle' => 'draft',
                    ])
                    ->label('Status'),
                Tables\Columns\TextColumn::make('owner.ownerType.name')
                ->label('Tipe Pemilik'),


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
            OwnerRelationManager::class,
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
