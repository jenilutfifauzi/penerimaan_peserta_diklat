<?php

namespace App\Filament\Exports;

use App\Models\KepemimpinanAdministrator;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class KepemimpinanAdministratorExporter extends Exporter
{
    protected static ?string $model = KepemimpinanAdministrator::class;

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
            ExportColumn::make('status_pelatihan_kepemimpinan')->label('Lulus Pelatihan Kepemimpinan Pengawas')
            ->formatStateUsing(function ($state) {
                return $state;
            }),
            ExportColumn::make('riwayat_diklat')->label('Riwayat Pelatihan'),
            ExportColumn::make('golongan')->label('Golongan'),
            ExportColumn::make('jabatan')->label('Jabatan'),
            ExportColumn::make('unit')->label('Unit'),
            ExportColumn::make('surat')->label('Surat'),
            ExportColumn::make('angkatan')->label('Angkatan'),
            ExportColumn::make('keterangan')->label('Keterangan'),
            ExportColumn::make('keterangan_2')->label('Keterangan 2')
            ->label('Keterangan 2')
            ->formatStateUsing(function (KepemimpinanAdministrator $record) {

                $riwayatPelatihan = $record->status_pelatihan_kepemimpinan;
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
                if ($riwayatPelatihan == 'Ya' && $umur <=54 && !in_array($golongan, $notSyaratGolongan)) {
                    $alasan = [];
                    $status = 'MS';
                    $alasans = '';
                } else {
                    if ($riwayatPelatihan != 'Ya') {
                        $alasan[] = 'Tidak Lulus Lulus Pelatihan Kepemimpinan Pengawas';
                    }

                    if ($umur > 54) {
                        $alasan[] = 'Umur lebih dari 54';
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
        $body = 'Your kepemimpinan administrator export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
