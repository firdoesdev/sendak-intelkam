<?php

namespace App\Filament\Resources\OwnerResource\RelationManagers;

use App\Enums\RekomStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Rekom;
use App\Models\Weapon;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
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

// use Filament\Tables\Columns\Column;

class RekomsRelationManager extends RelationManager
{

    protected static string $relationship = 'rekoms';
    protected static ?string $title = 'Rekom';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Fieldset::make('Detail Rekom')->schema([

                // ]),
                Grid::make(12)->schema([
                    Fieldset::make('Detail Rekom')->schema([
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
                        ->columnSpan(8),
                    Fieldset::make('Status')->schema([
                        Forms\Components\Radio::make('status')
                            ->options([
                                RekomStatusEnum::ACTIVE->value() => RekomStatusEnum::ACTIVE->label(),
                                RekomStatusEnum::EXPIRED->value() => RekomStatusEnum::EXPIRED->label(),
                                RekomStatusEnum::EXPIRED_SOON->value() => RekomStatusEnum::EXPIRED_SOON->label(),
                                RekomStatusEnum::DRAFT->value() => RekomStatusEnum::DRAFT->label(),
                            ])->default(RekomStatusEnum::DRAFT->value())
                            ->hiddenLabel()
                            ->columnSpanFull(),
                    ])

                        ->columnSpan(4)

                ]),

                Fieldset::make('Item')->schema([
                    Repeater::make('explosives')
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
                        ])
                        ->addActionLabel('Tambahkan Item')
                        ->addActionAlignment('right')
                        ->hiddenLabel()
                        ->collapsible()
                        ->itemLabel(fn(array $state): ?string => $state['name'] ? $state['name'] . ' (' . $state['serial'] . ')' . ' - ' . $state['qty'] . '' . $state['unit'] : null)
                        ->relationship('explosives')
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
                Tables\Columns\TextColumn::make('activated_at')
                    ->label('Durasi Rekom')
                    ->getStateUsing(fn(Model $record): ?string => Carbon::parse($record['activated_at'])->format('M d, y') . ' - ' . Carbon::parse($record['expired_at'])->format('M d, y'))
                    ->badge(),
           
                Tables\Columns\TextColumn::make('explosives.name')->label('Nama Bahan Peledak')
                    ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),
                Tables\Columns\TextColumn::make('explosives.serial')->label('Serial')
                    ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),
                Tables\Columns\TextColumn::make('explosives.qty')->label('Jumlah')
                    ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),
                Tables\Columns\TextColumn::make('explosives.unit')->label('Unit')
                    ->visible(auth()->user()->hasRole(RoleEnum::HANDAK->value()) ? true : false),

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
