<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

use App\Enums\RekomStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Rekom;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Role;

class RekomsRelationManager extends RelationManager
{

    protected static string $relationship = 'rekoms';
    protected static ?string $title = 'Rekom';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(6)->schema([
                    Group::make()->schema([
                        Forms\Components\TextInput::make('no_rekom')
                            ->required(),
                        Forms\Components\BelongsToSelect::make('rekom_type_id')
                            ->relationship('rekomType', 'name')
                            ->label('Jenis Rekom')
                            ->required(),

                        Forms\Components\DatePicker::make('activated_at')
                            ->label('Tanggal Rekom Terbit')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('expired_at')
                            ->label('Tanggal Rekom Kadaluarsa')
                            ->default(now()->addYear())
                            ->required(),
                    ])
                    ->columnSpan(4),
                    Forms\Components\Radio::make('status')
                        ->options([
                            RekomStatusEnum::ACTIVE->value() => RekomStatusEnum::ACTIVE->label(),
                            RekomStatusEnum::EXPIRED->value() => RekomStatusEnum::EXPIRED->label(),
                            RekomStatusEnum::EXPIRED_SOON->value() => RekomStatusEnum::EXPIRED_SOON->label(),
                            RekomStatusEnum::DRAFT->value() => RekomStatusEnum::DRAFT->label(),
                        ])->default(RekomStatusEnum::DRAFT->value()),
                ]),
                Grid::make(6)->schema([
                    Repeater::make('Explosives')
                        ->columnSpan(6)
                        ->schema([
                            Grid::make()->schema([
                                TextInput::make('name')
                                    ->label('Nama Bahan Peledak')
                                    ->required(),
                                TextInput::make('serial')
                                    ->label('serial')
                                    ->required(),
                                TextInput::make('qty')
                                    ->label('Jumlah')
                                    ->required(),
                                TextInput::make('unit')
                                    ->label('Satuan')
                                    ->required(),
                                Forms\Components\BelongsToSelect::make('warehouse')
                                ->label('Gudang')    
                                ->relationship('warehouse', 'name')

                            ]),
                        ])->relationship('explosives'),
                ])->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),

            ]);

        

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('no_rekom')
            ->columns([
                Tables\Columns\TextColumn::make('no_rekom'),
                Tables\Columns\TextColumn::make('rekomType.name')
                    ->label('Jenis Rekom')
                    ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),

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
                
                Tables\Columns\TextColumn::make('explosives.serial')->label('Serial')
                ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),
                Tables\Columns\TextColumn::make('explosives.name')->label('Nama Bahan Peledak')
                ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),
                Tables\Columns\TextColumn::make('explosives.qty')->label('Jumlah')
                ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),
                Tables\Columns\TextColumn::make('explosives.unit')->label('Unit')
                ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),
                    
                // Tables\Columns\TextColumn::make('explosives.name')->label('Nama Bahan Peledak'),
                // Tables\Columns\TextColumn::make('explosives.qty')->label('Jumlah'),
                // Tables\Columns\TextColumn::make('explosives.unit')->label('Unit'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Rekom'),
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                    ->label('Ubah'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
