<?php

namespace App\Filament\Exports;

use App\Models\Rekom;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RekomExporter extends Exporter
{
    protected static ?string $model = Rekom::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('no_rekom'),
            // ExportColumn::make('activated_at'),
            // ExportColumn::make('expired_at'),
            // ExportColumn::make('extended_times'),
            // ExportColumn::make('status'),
            // ExportColumn::make('role_id'),
            // ExportColumn::make('owner_id'),
            // ExportColumn::make('rekom_type_id'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your rekom export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
