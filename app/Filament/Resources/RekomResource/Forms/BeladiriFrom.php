<?php

namespace App\Filament\Resources\RekomResource\Forms;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Fieldset;

use App\Models\OwnerType;

class BeladiriFrom
{

    private static $ownershipType = 'Individual';
    public static function getSchema(): array
    {
        $defaultOwnership = OwnerType::where('name', self::$ownershipType)->first()->id;

        return [
            Grid::make(12)
                ->schema([
                    
                    Group::make([
                        BelongsToSelect::make('owner_type_id')
                            ->label('Jenis Kepemilikan')
                            ->relationship('ownerType', 'name')
                            ->required()
                            ->default($defaultOwnership)
                            ->disabled(true),
                        Fieldset::make('Data Kepemilikan')
                            ->schema([
                                TextInput::make('nama'),
                                TextInput::make('alamat')
                            ])->columnSpanFull(),
                    ])
                        ->relationship('owner')
                        ->columnSpan(8),
                    
                    Fieldset::make('Masa Berlaku')
                        ->schema([
                            Select::make('status')
                                ->options([
                                    'active' => 'active',
                                    'inactive' => 'inactive'
                                ])->columnSpanFull()
                        ])->columnSpan(4),

                        Fieldset::make('Info Senjata')
                        ->schema([
                            TextInput::make('serial_number')
                                ->label('Nomor Seri Senjata'),
                            TextInput::make('weapon_type')
                                ->label('Jenis Pistol'),
                            TextInput::make('caliber')
                                ->label('Kaliber')
                        ])->columnSpan(8),

                        
                 
                    

                   


                ]),


        ];
    }
}