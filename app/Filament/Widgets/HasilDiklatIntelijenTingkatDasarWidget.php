<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilDiklatIntelijenTingkatDasarExporter;
use App\Models\DiklatIntelijenTingkatDasar;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HasilDiklatIntelijenTingkatDasarWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Diklat Intelijen Tingkat Dasar';
    public function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(HasilDiklatIntelijenTingkatDasarExporter::class)
        ])
            ->query(
                DiklatIntelijenTingkatDasar::query()
                ->where('kode_pelatihan', 'diklat_intelijen_tingkat_dasar')
                ->where('status_riwayat_diklat', 'Tidak')
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
