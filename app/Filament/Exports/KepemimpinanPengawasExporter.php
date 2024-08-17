<?php

namespace App\Filament\Exports;

use App\Models\KepemimpinanPengawas;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class KepemimpinanPengawasExporter extends Exporter
{
    protected static ?string $model = KepemimpinanPengawas::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama')->label('Nama'),
            ExportColumn::make('nip')->label('NIP/NRP'),
            ExportColumn::make('tanggal_lahir')->label('Tanggal Lahir')
            ->formatStateUsing(function ($state) {
                return \Carbon\Carbon::parse($state)->format('d-m-Y');
            }),
            ExportColumn::make('age')->label('Umur')
            ->formatStateUsing(function ($state) {
                return $state . ' Tahun';
            }),
            ExportColumn::make('golongan')->label('Golongan'),
            ExportColumn::make('jabatan')->label('Jabatan'),
            ExportColumn::make('unit')->label('Unit'),
            ExportColumn::make('surat')->label('Surat'),
            ExportColumn::make('angkatan')->label('Angkatan'),
            ExportColumn::make('keterangan')->label('Keterangan'),
            ExportColumn::make('keterangan_2')->label('Keterangan 2')
            ->label('Keterangan 2')
            ->formatStateUsing(function (KepemimpinanPengawas $record) {
                $umur = $record->age;
                $golongan = $record->golongan;
                $alasan = [];
                $notSyaratGolongan =[
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
                if ( $umur <=54 && !in_array($golongan, $notSyaratGolongan)) {
                    $alasan = [];
                    $status = 'MS';
                    $alasans = '';
                } else {


                    if ($umur > 54) {
                        $alasan[] = 'Umur lebih dari 54';
                    }

                    if (in_array($golongan, $notSyaratGolongan)) {
                        $alasan[] = 'Golongan dibawah Golongan III/b ';
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
        $body = 'Your kepemimpinan pengawas export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
