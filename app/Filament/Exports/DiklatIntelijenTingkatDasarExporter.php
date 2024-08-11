<?php

namespace App\Filament\Exports;

use App\Models\DiklatIntelijenStrategis;
use App\Models\DiklatIntelijenTingkatDasar;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class DiklatIntelijenTingkatDasarExporter extends Exporter
{
    protected static ?string $model = DiklatIntelijenTingkatDasar::class;

    public static function getColumns(): array
    {

        return [
            ExportColumn::make('nama')->label('Nama'),
            ExportColumn::make('nip')->label('NIP'),
            ExportColumn::make('tanggal_lahir')->label('Tanggal Lahir')
            ->formatStateUsing(function ($state) {
                return \Carbon\Carbon::parse($state)->format('d-m-Y');
            }),
            ExportColumn::make('age')->label('Umur')
            ->formatStateUsing(function ($state) {
                return $state . ' Tahun';
            }),
            ExportColumn::make('status_riwayat_diklat')->label('Status Riwayat Diklat')
            ->formatStateUsing(function ($state) {
                return $state;
            }),
            ExportColumn::make('riwayat_diklat')->label('Riwayat Diklat'),
            ExportColumn::make('golongan')->label('Golongan'),
            ExportColumn::make('jabatan')->label('Jabatan'),
            ExportColumn::make('unit')->label('Unit'),
            ExportColumn::make('surat')->label('Surat'),
            ExportColumn::make('angkatan')->label('Angkatan'),
            ExportColumn::make('keterangan')->label('Keterangan'),
            ExportColumn::make('keterangan')->label('Keterangan'),
            ExportColumn::make('keterangan_2')->label('Keterangan 2')
            ->state(function (DiklatIntelijenTingkatDasar $record): string {
                $riwayatDiklat = $record->status_riwayat_diklat == 'Tidak' ? 'Tidak' : 'Ya';
                $umur = $record->age;
                $golongan = $record->golongan;
                $alasan = [];

                if ($riwayatDiklat == 'Tidak' && $umur <= 35 && !in_array($golongan, ['II/b', 'II/a', 'I/d', 'I/c', 'I/b', 'I/a'])) {
                    $alasan = [];
                    $status = 'MS';
                    $alasans = '';
                } else {
                    if ($riwayatDiklat != 'Tidak') {
                        $alasan[] = 'Riwayat Diklat';
                    }
                    if ($umur > 35) {
                        $alasan[] = 'Umur lebih dari 35';
                    }
                    if (in_array($golongan, ['II/b', 'II/a', 'I/d', 'I/c', 'I/b', 'I/a'])) {
                        $alasan[] = 'Golongan dibawah Golongan II/c';
                    }
                    $alasans = implode(', ', $alasan);
                    $status = 'TM';
                }

                return $status . ' - ' . $alasans;
            })
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your diklat intelijen tingkat dasar export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
