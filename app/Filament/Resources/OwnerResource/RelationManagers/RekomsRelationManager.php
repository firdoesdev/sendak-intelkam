<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

use App\Enums\RekomStatusEnum;
use App\Enums\RoleEnum;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;

use Spatie\Permission\Models\Role;

class RekomsRelationManager extends RelationManager
{

    protected static string $relationship = 'rekoms';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_rekom')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('activated_at')
                    ->label('Tanggal Rekom Terbit')
                    ->default(now())
                    ->required(),
                Forms\Components\DatePicker::make('expired_at')
                    ->label('Tanggal Rekom Kadaluarsa')
                    ->default(now()->addYear())
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        RekomStatusEnum::ACTIVE->value() => RekomStatusEnum::ACTIVE->label(),
                        RekomStatusEnum::EXPIRED->value() => RekomStatusEnum::EXPIRED->label(),
                        RekomStatusEnum::EXPIRED_SOON->value() => RekomStatusEnum::EXPIRED_SOON->label(),
                        RekomStatusEnum::DRAFT->value() => RekomStatusEnum::DRAFT->label(),
                    ])->default( RekomStatusEnum::DRAFT->value()),
            ]);

        // return $form;

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('no_rekom')
            ->columns([
                Tables\Columns\TextColumn::make('no_rekom'),

                Tables\Columns\TextColumn::make('role.name')
                    ->label('Divisi'),
               
                Tables\Columns\TextColumn::make('activated_at')
                    ->label('Tgl Rekom Terbit')
                    ->extraAttributes(['class' => 'color-red-500'])
                    ->date(),
                Tables\Columns\TextColumn::make('expired_at')
                    ->label('Tgl Rekom Kadaluarsa')
                    ->date(),
                Tables\Columns\BadgeColumn::make('status')
                    ->formatStateUsing(fn (string $state): string => RekomStatusEnum::from($state)->label())
                    ->icons([
                        'heroicon-s-check-circle' => RekomStatusEnum::ACTIVE->value(),
                        'heroicon-s-x-circle' => RekomStatusEnum::EXPIRED->value(),
                        'heroicon-s-exclamation-triangle' => RekomStatusEnum::EXPIRED_SOON->value(),
                        'heroicon-s-question-mark-circle' =>RekomStatusEnum::DRAFT->value(),
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
