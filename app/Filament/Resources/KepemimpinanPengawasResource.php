<?php

namespace App\Filament\Resources;

use App\Filament\Exports\KepemimpinanPengawasExporter;
use App\Filament\Resources\KepemimpinanPengawasResource\Pages;
use App\Filament\Resources\KepemimpinanPengawasResource\RelationManagers;
use App\Models\KepemimpinanPengawas;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KepemimpinanPengawasResource extends Resource
{
    protected static ?string $model = KepemimpinanPengawas::class;

    protected static ?string $navigationLabel = 'Kepemimpinan Pengawas';

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextInput::make('kode_pelatihan')->label('Kode Pelatihan')->default('kepemimpinan_pengawas')->readOnly(),
                DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->date()->required(),
                TextInput::make('nip')->label('NIP/NRP')->numeric()->required(),
                Select::make('golongan')->label('Golongan')->required()
                    ->options($golongans)->searchable(),
                TextInput::make('jabatan')->label('Jabatan')->required()
                    ->datalist($jabatans),
                TextInput::make('unit')->label('Unit')->required(),
                TextInput::make('surat')->label('No Surat')->required(),
                DatePicker::make('tanggal_surat')->label('Tanggal Surat')->required(),

                TextInput::make('angkatan')->label('Angkatan')->required()
                    ->datalist([
                        'Seno'
                    ]),
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
                ->exporter(KepemimpinanPengawasExporter::class)->label('Export Kepemimpinan Pengawas')
        ])
            ->query(
                KepemimpinanPengawas::query()
                ->where('kode_pelatihan', 'kepemimpinan_pengawas')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama'),
                Tables\Columns\TextColumn::make('nip')->label('NIP/NRP'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->label('Tanggal Lahir'),
                Tables\Columns\TextColumn::make('age')->label('Umur'),
                Tables\Columns\TextColumn::make('riwayat_diklat')->label('Riwayat Pelatihan'),
                Tables\Columns\TextColumn::make('golongan')->label('Golongan'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('unit')->label('Unit'),
                Tables\Columns\TextColumn::make('surat')->label('Surat'),
                Tables\Columns\TextColumn::make('angkatan')->label('Angkatan')->extraAttributes(['class' => 'col-12']),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),
                BadgeColumn::make('keterangan_2')
                    ->label('Keterangan 2')
                    ->formatStateUsing(function (KepemimpinanPengawas $record) {
                        $umur = $record->age;
                        $golongan = $record->golongan;
                        $alasan = [];
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
                        if ( $umur <=54 && !in_array($golongan, $notSyaratGolongan)) {
                            $alasan = [];
                            $status = 'MS';
                            $alasans = '';
                        } else {


                            if ($umur > 54) {
                                $alasan[] = 'Umur lebih dari 54';
                            }

                            if (in_array($golongan, $notSyaratGolongan)) {
                                $alasan[] = 'Golongan dibawah Golongan III/b ';
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
            'index' => Pages\ManageKepemimpinanPengawas::route('/'),
        ];
    }
}
