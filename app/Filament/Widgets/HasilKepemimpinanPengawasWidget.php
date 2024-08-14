<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilKepemimpinanPengawasExporter;
use App\Models\KepemimpinanPengawas;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HasilKepemimpinanPengawasWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Kepemimpinan Pengawas';
    public function table(Table $table): Table
    {

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
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(HasilKepemimpinanPengawasExporter::class)
        ])
            ->query(
                KepemimpinanPengawas::query()
                ->where('kode_pelatihan', 'kepemimpinan_pengawas')
                ->whereNotIn('golongan', $notSyaratGolongan)
                ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 54')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                
            ]);
    }
}
