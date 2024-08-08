<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilTeknisIntelijenIExporter;
use App\Models\TeknisIntelijenI;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HasilTeknisIntelijenI extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Teknik Intelijen I';
    public function table(Table $table): Table
    {

        $notSyaratGolongan =[
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
                ->exporter(HasilTeknisIntelijenIExporter::class)
        ])
            ->query(
                TeknisIntelijenI::query()
                ->where('kode_pelatihan', 'teknis_intelijen_i')
                ->where('status_riwayat_diklat', 'YA')
                ->whereNotIn('golongan', $notSyaratGolongan)
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 40')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                
            ]);
    }
}
