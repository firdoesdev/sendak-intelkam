<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekomResource\Pages;
use App\Filament\Resources\RekomResource\RelationManagers;
use App\Models\Rekom;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Spatie\Permission\Models\Role;


class RekomResource extends Resource
{
    protected static ?string $model = Rekom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {

        // dump(auth()->user()->hasRole('super-admin'));
        return $form
            ->schema([
                Grid::make(12)->schema([

                    Fieldset::make('Data Pemilik')->schema([
                        Forms\Components\Select::make('no_rekom')
                            ->label('Jenis Kepemilikan')
                            ->options([
                                'Perorangan' => 'Perorangan',
                                'Perusahaan' => 'Perusahaan'
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('no_rekom')
                            ->label('NIK')
                            ->required(),
                        Forms\Components\TextInput::make('no_rekom')
                            ->label('Nama')
                            ->required(),
                        Forms\Components\TextInput::make('no_rekom')
                            ->label('Alamat')
                            ->required(),
                        Forms\Components\TextInput::make('no_rekom')
                            ->label('Nomor Telepon')
                            ->required(),
                    ])->columnSpan(8),

                    Fieldset::make('Masa Berlaku')->schema([

                        Placeholder::make('Masa Berlaku')
                        ->content(
                            now()),
                       
                        Forms\Components\DatePicker::make('no_rekom')
                        ->label('Masa Berlaku')
                        ->default(now())
                        ->columnSpanFull(),
                        
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('Update Masa Berlaku')
                                
                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                    $set('excerpt', str($get('content'))->words(45, end: ''));
                                })->requiresConfirmation()
                        ])
                        ->columnSpanFull(),
                        
                        
                    ])
                    ->columnSpan(4),

                    Fieldset::make('Data Senjata')->schema([
                        Forms\Components\TextInput::make('no_rekom')
                            ->label('Nomor Seri Senjata'),
                        Forms\Components\Select::make('no_rekom')
                            ->label('Jenis Senjata')
                            ->options([
                                'Perorangan' => 'Perorangan',
                                'Perusahaan' => 'Perusahaan'
                            ]),
                        Forms\Components\TextInput::make('no_rekom')
                            ->label('Kaliber'),
                        Forms\Components\Select::make('no_rekom')
                            ->options([
                                'Polsek gresik'
                            ])
                            ->label('Gudang Penyimpanan'),
                    ])->columnSpan(8),


                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('role.name')->label('Division'),
                Tables\Columns\TextColumn::make('no_rekom'),
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
