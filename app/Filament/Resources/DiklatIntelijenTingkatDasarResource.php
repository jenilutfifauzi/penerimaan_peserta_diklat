<?php

namespace App\Filament\Resources;

use App\Filament\Exports\DiklatIntelijenTingkatDasarExporter;
use App\Filament\Resources\DiklatIntelijenTingkatDasarResource\Pages;
use App\Filament\Resources\DiklatIntelijenTingkatDasarResource\RelationManagers;
use App\Models\DiklatIntelijenTingkatDasar;
use App\Models\PesertaPelatihan;
use Faker\Provider\ar_EG\Text;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Component;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Request;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\BadgeColumn;

class DiklatIntelijenTingkatDasarResource extends Resource
{
    protected static ?string $model = DiklatIntelijenTingkatDasar::class;
    protected static ?string $navigationLabel = 'Diklat Intelijen Tingkat Dasar';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected $kode_pelatihan;

    public function __construct($model = null)
    {
        parent::__construct($model);
        $this->kode_pelatihan = 'diklat_intelijen_tingkat_dasar';
    }

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
                TextInput::make('kode_pelatihan')->label('Kode Pelatihan')->default('diklat_intelijen_tingkat_dasar')->readOnly(),
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
                Select::make('status_riwayat_diklat')->label('Riwayat Diklat')->required()
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
                TextInput::make('keterangan_2')->label('Keterangan 2')
                    ->default('-')->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $notSyaratGolongan = [
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
                    ->exporter(DiklatIntelijenTingkatDasarExporter::class)->label('Export Diklat Intelijen Tingkat Dasar'),

                Action::make('deleteall')
                    ->label('Delete All')
                    ->url(fn(): string => route('admin.deleteAll', ['kode_pelatihan' => 'diklat_intelijen_tingkat_dasar']))
                    ->requiresConfirmation()
                    ->modalHeading('Delete post')
                    ->modalDescription('Are you sure you\'d like to delete this post? This cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete it')
                    ->successNotification(
                        Notification::make()
                             ->success()
                             ->title('Data berhasil dihapus')
                             ->body('The selected data has been deleted.')
                     )
            ])
            ->query(
                DiklatIntelijenTingkatDasar::query()
                    ->where('kode_pelatihan', 'diklat_intelijen_tingkat_dasar')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama'),
                Tables\Columns\TextColumn::make('nip')->label('NIP/NRP'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')
                    ->dateTime('d-m-Y'),

                Tables\Columns\TextColumn::make('age')->label('Umur'),
                Tables\Columns\TextColumn::make('status_riwayat_diklat')->label('Status Riwayat Diklat'),
                Tables\Columns\TextColumn::make('riwayat_diklat')->label('Riwayat Diklat'),
                Tables\Columns\TextColumn::make('golongan')->label('Golongan'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('unit')->label('Unit'),
                Tables\Columns\TextColumn::make('surat')->label('Surat'),
                Tables\Columns\TextColumn::make('tanggal_surat')->label('Tanggal Surat'),
                Tables\Columns\TextColumn::make('angkatan')->label('Angkatan'),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),
                BadgeColumn::make('keterangan_2')
                    ->label('Keterangan 2')
                    ->formatStateUsing(function (DiklatIntelijenTingkatDasar $record) {

                        $riwayatDiklat = $record->status_riwayat_diklat == 'Tidak' ? 'Tidak' : 'Ya';
                        $umur = $record->age;
                        $golongan = $record->golongan;
                        $alasan = [];

                        if ($riwayatDiklat == 'Tidak' && $umur <= 35 && !in_array($golongan, ['II/b', 'II/a', 'I/d', 'I/c', 'I/b', 'I/a'])) {
                            $alasan = [];
                            $status = 'MS';
                            $alasans = '';
                        } else {
                            if ($riwayatDiklat != 'Tidak') {
                                $alasan[] = 'Riwayat Diklat';
                            }
                            if ($umur > 35) {
                                $alasan[] = 'Umur lebih dari 35';
                            }
                            if (in_array($golongan, ['II/b', 'II/a', 'I/d', 'I/c', 'I/b', 'I/a'])) {
                                $alasan[] = 'Golongan dibawah Golongan II/c';
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiklatIntelijenTingkatDasars::route('/'),
            'create' => Pages\CreateDiklatIntelijenTingkatDasar::route('/create'),
            'edit' => Pages\EditDiklatIntelijenTingkatDasar::route('/{record}/edit'),
        ];
    }
}
