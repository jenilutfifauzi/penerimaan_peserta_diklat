<?php

namespace App\Filament\Resources;

use App\Filament\Exports\DiklatIntelijenTingkatIIExporter;
use App\Filament\Resources\DiklatIntelijenTingkatIIResource\Pages;
use App\Filament\Resources\DiklatIntelijenTingkatIIResource\RelationManagers;
use App\Models\DiklatIntelijenTingkatII;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiklatIntelijenTingkatIIResource extends Resource
{
    protected static ?string $model = DiklatIntelijenTingkatII::class;

    protected static ?string $navigationLabel = 'Diklat Intelijen Tingkat II';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        $options = [
            'Pembina Utama' => 'Pembina Utama',
            'Pembina Utama Madya ' => 'Pembina Utama Madya ',
            'Pembina Utama Muda' => 'Pembina Utama Muda',
            'Pembina Tk I' => 'Pembina Tk I',
            'Pembina' => 'Pembina',
            'Penata Tk I' => 'Penata Tk I',
            'Penata' => 'Penata',
            'Penata Muda Tk I' => 'Penata Muda Tk I',
            'Penata Muda' => 'Penata Muda',
            'Pengatur Tk I' => 'Pengatur Tk I',
            'Pengatur' => 'Pengatur',
            'Pengatur Muda Tk I' => 'Pengatur Muda Tk I',
            'Pengatur Muda' => 'Pengatur Muda',
            'Juru Tk I' => 'Juru Tk I',
            'Juru' => 'Juru',
            'Juru Muda Tk I' => 'Juru Muda Tk I',
            'Juru Muda' => 'Juru Muda',
        ];

        $jabatans = [
            'JPT Utama',
            'JPT Madya',
            'JPT Pratama',
            'Administrator',
            'Pengawas',
            'Pelaksana',
        ];

        $golongans = [
            'I/a' => 'I/a',
            'I/b' => 'I/b',
            'I/c' => 'I/c',
            'I/d' => 'I/d',
            'II/a' => 'II/a',
            'II/b' => 'II/b',
            'II/c' => 'II/c',
            'II/d' => 'II/d',
            'III/a' => 'III/a',
            'III/b' => 'III/b',
            'III/c' => 'III/c',
            'III/d' => 'III/d',
            'IV/a' => 'IV/a',
            'IV/b' => 'IV/b',
            'IV/c' => 'IV/c',
            'IV/d' => 'IV/d',
        ];
        return $form
            ->schema([
                TextInput::make('nama')->label('Nama')->required(),
                TextInput::make('kode_pelatihan')->label('Kode Pelatihan')->default('diklat_intelijen_tingkat_ii')->readOnly(),
                DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->date()->required(),
                TextInput::make('nip')->label('NIP/NRP')->numeric()->required(),
                Select::make('pangkat')->label('Pangkat')->required()
                    ->options($options)->searchable(),
                Select::make('golongan')->label('Golongan')->required()
                    ->options($golongans)->searchable(),
                TextInput::make('jabatan')->label('Jabatan')->required()
                    ->datalist($jabatans),
                TextInput::make('unit')->label('Unit')->required(),
                TextInput::make('surat')->label('No Surat')->required(),
                DatePicker::make('tanggal_surat')->label('Tanggal Surat')->required(),
                Select::make('status_riwayat_diklat')->label('Lulus Diklat Intelijen Tingkat I')->required()
                    ->options([
                        'Ya' => 'Ya',
                        'Tidak' => 'Tidak',
                    ]),
                Select::make('status_riwayat_diklat_dua_lulus')->label('Lulus Dua Diklat Teknis Intelijen I')->required()
                    ->options([
                        'Ya' => 'Ya',
                        'Tidak' => 'Tidak',
                    ]),
                TextInput::make('angkatan')->label('Angkatan')->required()
                    ->datalist([
                        'Seno'
                    ]),
                MarkdownEditor::make('riwayat_diklat')->label('Riwayat Diklat')->required(),
                MarkdownEditor::make('keterangan')
                    ->toolbarButtons([
                        'attachFiles',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'edit',
                        'italic',
                        'link',
                        'orderedList',
                        'preview',
                        'strike',
                    ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(DiklatIntelijenTingkatIIExporter::class)->label('Export Diklat Intelijen Tingkat II'),
        ])
            ->query(
                DiklatIntelijenTingkatII::query()
                ->where('kode_pelatihan', 'diklat_intelijen_tingkat_ii')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama'),
                Tables\Columns\TextColumn::make('nip')->label('NIP/NRP'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->label('Tanggal Lahir'),
                Tables\Columns\TextColumn::make('age')->label('Umur'),
                Tables\Columns\TextColumn::make('status_riwayat_diklat')->label('Lulus Diklat Intelijen Tingkat I'),
                Tables\Columns\TextColumn::make('status_riwayat_diklat_dua_lulus')->label('Lulus Dua Diklat Teknis Intelijen I'),
                Tables\Columns\TextColumn::make('riwayat_diklat')->label('Riwayat Diklat'),
                Tables\Columns\TextColumn::make('golongan')->label('Golongan'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('unit')->label('Unit'),
                Tables\Columns\TextColumn::make('surat')->label('Surat'),
                Tables\Columns\TextColumn::make('angkatan')->label('Angkatan'),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),
                BadgeColumn::make('keterangan_2')
                    ->label('Keterangan 2')
                    ->formatStateUsing(function (DiklatIntelijenTingkatII $record) {

                        $riwayatDiklat = $record->status_riwayat_diklat;
                        $riwayatDiklatDua = $record->status_riwayat_diklat_dua_lulus;
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
                        if ($riwayatDiklat == 'Ya' && $riwayatDiklatDua == 'Ya' && $umur <= 40 && !in_array($golongan, $notSyaratGolongan)) {
                            $alasan = [];
                            $status = 'MS';
                            $alasans = '';
                        } else {
                            if ($riwayatDiklat != 'Ya') {
                                $alasan[] = 'Tidak Lulus Diklat Intelijen Tingkat Dasar 1';
                            }
                            if ($riwayatDiklatDua != 'Ya') {
                                $alasan[] = 'Tidak Lulus Dua Diklat Teknis Intelijen I';
                            }
                            if ($umur > 40) {
                                $alasan[] = 'Umur lebih dari 40';
                            }
                            if (in_array($golongan, $notSyaratGolongan)) {
                                $alasan[] = 'Golongan dibawah Golongan III/c ';
                            }
                            $alasans = implode(', ', $alasan);
                            $status = 'TM';
                        }
                        return $status . ' - ' . $alasans;
                    })
                    ->colors([
                        'success' => 'MS',
                        'danger' => 'TM',
                    ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDiklatIntelijenTingkatIIS::route('/'),
        ];
    }
}
