<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\HasilKepemimpinanAdministratorExporter;
use App\Models\KepemimpinanAdministrator;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HasilKepemimpinanAdministratorWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected $label = 'Ranking Kepemimpinan Administrator';
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
                ->exporter(HasilKepemimpinanAdministratorExporter::class)
        ])
            ->query(
                KepemimpinanAdministrator::query()
                ->where('kode_pelatihan', 'kepemimpinan_administrator')
                ->where('status_pelatihan_kepemimpinan', 'YA')
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
