<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOwners extends ListRecords
{
    protected static string $resource = OwnerResource::class;

    protected static ?string $title = 'Daftar Pemilik';
    
    public function getBreadcrumbs(): array
    {
        return [
            '/admin/owners' => 'Data Kepemilikan',
            '' => 'List',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Baru'),
        ];
    }
}
