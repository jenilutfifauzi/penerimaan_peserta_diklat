<?php

namespace App\Filament\Exports;

use App\Models\HasilDiklatIntelijenTingkatDasar;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class HasilDiklatIntelijenTingkatDasarExporter extends Exporter
{
    protected static ?string $model = HasilDiklatIntelijenTingkatDasar::class;

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
        $body = 'Data Ranking diklat intelijen tingkat dasar berhasil diexport ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported. Silahkan download file export.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
