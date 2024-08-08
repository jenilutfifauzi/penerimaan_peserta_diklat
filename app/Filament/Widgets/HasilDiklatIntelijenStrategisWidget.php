<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilDiklatIntelijenStrategisExporter;
use App\Models\DiklatIntelijenStrategis;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HasilDiklatIntelijenStrategisWidget extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Diklat Intelijen Tingkat Dasar II';
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
                    ->exporter(HasilDiklatIntelijenStrategisExporter::class)
            ])
            ->query(
                DiklatIntelijenStrategis::query()
                    ->where('kode_pelatihan', 'diklat_intelijen_strategis')
                    ->where('status_riwayat_diklat', 'Ya')
                    ->where('status_riwayat_diklat_dua_lulus', 'YA')
                    ->whereNotIn('golongan', $notSyaratGolongan)
                    ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 50')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),

            ]);
    }
}
