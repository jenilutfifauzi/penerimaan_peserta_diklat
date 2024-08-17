<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilTeknisIntelijenIIIExporter;
use App\Models\TeknisIntelijenIII;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HasilTeknisIntelijenIII extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Teknik Intelijen II';
    public function table(Table $table): Table
    {

        $notSyaratGolongan =[
            'III/d',
            'III/c',
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
                ->exporter(HasilTeknisIntelijenIIIExporter::class)->label('Export Hasil Teknis Intelijen III')
        ])
            ->query(
                TeknisIntelijenIII::query()
                ->where('kode_pelatihan', 'teknis_intelijen_iii')
                ->where('status_riwayat_diklat_dua_lulus', 'YA')
                ->whereNotIn('golongan', $notSyaratGolongan)
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 50')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP/NRP'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),

            ]);
    }
}
