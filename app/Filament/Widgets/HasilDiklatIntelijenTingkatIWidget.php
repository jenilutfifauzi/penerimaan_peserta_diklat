<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilDiklatIntelijenTingkatIExporter;
use App\Models\DiklatIntelijenTingkatI;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\ExportAction;

class HasilDiklatIntelijenTingkatIWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Diklat Intelijen Tingkat Dasar';
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
                ->exporter(HasilDiklatIntelijenTingkatIExporter::class)
        ])
            ->query(
                DiklatIntelijenTingkatI::query()
                ->where('kode_pelatihan', 'diklat_intelijen_tingkat_i')
                ->where('status_riwayat_diklat', 'YA')
                ->whereNotIn('golongan', $notSyaratGolongan)
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 35')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                
            ]);
    }
}
