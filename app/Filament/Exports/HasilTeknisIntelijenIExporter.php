<?php

namespace App\Filament\Exports;

use App\Models\HasilTeknisIntelijenI;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class HasilTeknisIntelijenIExporter extends Exporter
{
    protected static ?string $model = HasilTeknisIntelijenI::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama'),
            ExportColumn::make('nip')->label('NIP/NRP'),
            ExportColumn::make('pangkat'),
            ExportColumn::make('jabatan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your hasil teknis intelijen i export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
