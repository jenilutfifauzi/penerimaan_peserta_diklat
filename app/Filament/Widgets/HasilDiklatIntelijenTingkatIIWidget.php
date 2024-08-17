<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilDiklatIntelijenTingkatIIExporter;
use App\Models\DiklatIntelijenTingkatII;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\ExportAction;

class HasilDiklatIntelijenTingkatIIWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Diklat Intelijen Tingkat Dasar II';
    public function table(Table $table): Table
    {
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
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(HasilDiklatIntelijenTingkatIIExporter::class)->label('Export Hasil Diklat Intelijen Tingkat II')
        ])
            ->query(
                DiklatIntelijenTingkatII::query()
                ->where('kode_pelatihan', 'diklat_intelijen_tingkat_ii')
                ->where('status_riwayat_diklat', 'YA')
                ->where('status_riwayat_diklat_dua_lulus', 'YA')
                ->whereNotIn('golongan', $notSyaratGolongan)
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 40')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP/NRP'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),

            ]);
    }
}
