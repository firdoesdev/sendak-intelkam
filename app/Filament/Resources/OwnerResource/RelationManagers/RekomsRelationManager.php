<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

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
        // return $form
        //     ->schema([
        //         Forms\Components\TextInput::make('no_rekom')
        //             ->required()
        //             ->columnSpanFull(), 
        //         Forms\Components\DatePicker::make('activated_at')
        //             ->label('Tanggal Rekom Terbit')
        //             ->default(now())
        //             ->required(),
        //         Forms\Components\DatePicker::make('expired_at')
        //             ->label('Tanggal Rekom Kadaluarsa')
        //             ->default(now()->addYear())
        //             ->required(),
        //     ]);
    
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
                Tables\Columns\TextColumn::make('activated_at')
                ->label('Tanggal Rekom Terbit')
                ->date(),
                Tables\Columns\TextColumn::make('expired_at')
                ->label('Tanggal Rekom Kadaluarsa')
                ->date(),
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
