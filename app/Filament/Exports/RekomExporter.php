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
            ExportColumn::make('no_rekom')->label('No Rekom'),
            // ExportColumn::make('role.name')->label('Divisi'),
            // ExportColumn::make('activated_at')->label('Tgl Rekom Terbit'),
            // ExportColumn::make('expired_at')->label('Tgl Rekom Kadaluarsa'),
            ExportColumn::make('status')->label('Status'),
            //
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
