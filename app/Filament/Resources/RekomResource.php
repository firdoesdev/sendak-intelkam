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
use Illuminate\Contracts\Support\Htmlable;

class RekomResource extends Resource
{
    protected static ?string $model = Rekom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    TextInput::make('no_rekom')
                        ->required()
                        ->validationMessages([
                            'required' => 'No. Rekom Harus Diisi',
                        ]),
                    Select::make('status')
                        ->options([
                            RekomStatusEnum::ACTIVE->value() => RekomStatusEnum::ACTIVE->label(),
                            RekomStatusEnum::EXPIRED->value() => RekomStatusEnum::EXPIRED->label(),
                            RekomStatusEnum::EXPIRED_SOON->value() => RekomStatusEnum::EXPIRED_SOON->label(),
                            RekomStatusEnum::DRAFT->value() => RekomStatusEnum::DRAFT->label()
                        ])
                        ->required(),
                    DatePicker::make('activated_at')
                        ->label('Tgl Rekom Terbit')
                        ->before('expired_at')
                        ->validationMessages([
                            'before' => 'Tgl Rekom Terbit Harus Sebelum Tgl Rekom Kadaluarsa',
                        ])
                        ->required(),
                    DatePicker::make('expired_at')
                        ->label('Tgl Kadaluarsa')
                        ->required(),
                ])
        ]);



    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('no_rekom')->label('No Rekom')
                    ->default('-')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('activated_at')
                    ->label('Tgl Rekom Terbit')
                    ->date(),
                Tables\Columns\TextColumn::make('expired_at')
                    ->label('Tgl Rekom Kadaluarsa')
                    ->date(),
                Tables\Columns\BadgeColumn::make('status')
                    ->formatStateUsing(fn(string $state): string => RekomStatusEnum::from($state)->label())
                    ->icons([
                        'heroicon-s-check-circle' => RekomStatusEnum::ACTIVE->value(),
                        'heroicon-s-x-circle' => RekomStatusEnum::EXPIRED->value(),
                        'heroicon-s-exclamation-triangle' => RekomStatusEnum::EXPIRED_SOON->value(),
                        'heroicon-s-question-mark-circle' => RekomStatusEnum::DRAFT->value(),
                    ])
                    ->colors([
                        'success' => RekomStatusEnum::ACTIVE->value(),
                        'danger' => RekomStatusEnum::EXPIRED->value(),
                        'warning' => RekomStatusEnum::EXPIRED_SOON->value(),
                        'info' => RekomStatusEnum::DRAFT->value(),
                    ])
                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->defaultGroup('status')
            ->defaultSort('created_at', 'desc')
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
