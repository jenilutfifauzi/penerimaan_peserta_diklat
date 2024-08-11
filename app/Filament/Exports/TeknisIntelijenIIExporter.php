<?php

namespace App\Filament\Exports;

use App\Models\TeknisIntelijenII;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TeknisIntelijenIIExporter extends Exporter
{
    protected static ?string $model = TeknisIntelijenII::class;

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
            ExportColumn::make('status_riwayat_diklat_dua_lulus')->label('Lulus Dua Diklat Teknis Intelijen I')
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
            ExportColumn::make('keterangan_2')->label('Keterangan 2')
            ->formatStateUsing(function (TeknisIntelijenII $record) {

                $riwayatDiklat = $record->status_riwayat_diklat;
                $riwayatDiklatDua = $record->status_riwayat_diklat_dua_lulus;
                $umur = $record->age;
                $golongan = $record->golongan;
                $alasan = [];
                $notSyaratGolongan =[
                    'III/b',
                    'III/a',
                    'II/d',
                    'II/c',
                    'II/b',
                    'II/a',
                    'I/d',
                    'I/c',
                    'I/b',
                    'I/a',
                ];
                if ($riwayatDiklatDua == 'Ya' && $umur <=45 && !in_array($golongan, $notSyaratGolongan)) {
                    $alasan = [];
                    $status = 'MS';
                    $alasans = '';
                } else {
                    if ($riwayatDiklatDua != 'Ya') {
                        $alasan[] = 'Tidak Lulus Dua Diklat Teknis Intelijen I';
                    }

                    if ($umur > 45) {
                        $alasan[] = 'Umur lebih dari 45';
                    }
    
                    if (in_array($golongan, $notSyaratGolongan)) {
                        $alasan[] = 'Golongan dibawah Golongan III/c ';
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
        $body = 'Your teknis intelijen i i export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
