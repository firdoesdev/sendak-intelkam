<?php

namespace App\Filament\Resources\RekomResource\Forms;

use App\Models\WeaponType;
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

        $weaponTypes = WeaponType::pluck('name', 'id');

        return [
            Grid::make(12)
                ->schema([
                    
                    Group::make([
                        BelongsToSelect::make('owner_type_id')
                            ->label('Jenis Kepemilikan')
                            ->relationship('ownerType', 'name')
                            ->required()
                            ->default($defaultOwnership)
                            ->disabled(true)
                            ->columnSpan(8),
                        Fieldset::make('Data Kepemilikan')
                            ->schema([
                                TextInput::make('name'),
                                TextInput::make('address')
                            ])->columnSpan(8),

                        Fieldset::make('Info Senjata')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nomor Seri Senjata'),
                                // TextInput::make('weapons.name'),
                                // Select::make('weapons.weapon_type_id')
                                //     ->placeholder('Masukan Jenis Senjata')
                                //     ->options($weaponTypes)
                                //     ->label('Jenis Pistol'),
                                // TextInput::make('weapons.caliber')
                                //     ->label('Kaliber')
                            ])
                            ->columnSpan(8),
                    ])
                        ->relationship('owner')
                        ->columnSpan(8),
                    
                ]),


        ];
    }
}