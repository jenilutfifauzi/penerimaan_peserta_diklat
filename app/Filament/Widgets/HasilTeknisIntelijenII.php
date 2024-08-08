<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilTeknisIntelijenIIExporter;
use App\Models\TeknisIntelijenII;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HasilTeknisIntelijenII extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Teknik Intelijen II';
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
                ->exporter(HasilTeknisIntelijenIIExporter::class)
        ])
            ->query(
                TeknisIntelijenII::query()
                ->where('kode_pelatihan', 'teknis_intelijen_ii')
                ->where('status_riwayat_diklat_dua_lulus', 'YA')
                ->whereNotIn('golongan', $notSyaratGolongan)
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 45')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                
            ]);
    }
}
