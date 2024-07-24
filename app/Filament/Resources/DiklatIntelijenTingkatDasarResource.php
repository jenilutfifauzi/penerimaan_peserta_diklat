<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiklatIntelijenTingkatDasarResource\Pages;
use App\Filament\Resources\DiklatIntelijenTingkatDasarResource\RelationManagers;
use App\Models\DiklatIntelijenTingkatDasar;
use App\Models\PesertaPelatihan;
use Faker\Provider\ar_EG\Text;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
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

class DiklatIntelijenTingkatDasarResource extends Resource
{
    protected static ?string $model = DiklatIntelijenTingkatDasar::class;
    protected static ?string $navigationLabel = 'Diklat Intelijen Tingkat Dasar';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $options = [
            'Pembina Utama, IV/e' => 'Pembina Utama, IV/e',
            'Pembina Utama Madya , IV/d' => 'Pembina Utama Madya , IV/d',
            'Pembina Utama Muda, IV/c' => 'Pembina Utama Muda, IV/c',
            'Pembina Tk I, IV/b' => 'Pembina Tk I, IV/b',
            'Pembina, IV/a' => 'Pembina, IV/a',
            'Penata Tk I, III/d' => 'Penata Tk I, III/d',
            'Penata, III/c' => 'Penata, III/c',
            'Penata Muda Tk I, III/b' => 'Penata Muda Tk I, III/b',
            'Penata Muda, III/a' => 'Penata Muda, III/a',
            'Pengatur Tk I, II/d' => 'Pengatur Tk I, II/d',
            'Pengatur, II/c' => 'Pengatur, II/c',
            'Pengatur Muda Tk I, II/b' => 'Pengatur Muda Tk I, II/b',
            'Pengatur Muda, II/a' => 'Pengatur Muda, II/a',
            'Juru Tk I, I/d' => 'Juru Tk I, I/d',
            'Juru, I/c' => 'Juru, I/c',
            'Juru Muda Tk I, I/b' => 'Juru Muda Tk I, I/b',
            'Juru Muda, I/a' => 'Juru Muda, I/a',
        ];

        $jabatans = [
            'JPT Utama',
            'JPT Madya',
            'JPT Pratama',
            'Administrator',
            'Pengawas',
            'Pelaksana',
        ];
        return $form
            ->schema([
                TextInput::make('nama')->label('Nama')->required(),
                TextInput::make('kode_pelatihan')->label('Kode Pelatihan')->default('diklat_intelijen_tingkat_dasar')->readOnly(),
                DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->date()->required(),
                TextInput::make('nip')->label('NIP')->numeric()->required(),
                Select::make('pangkat')->label('Pangkat')->required()
                    ->options($options)->searchable(),
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
                TextInput::make('angkatan')->label('Angkatan')->required()
                    ->datalist([
                        'Seno'
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Nama'),
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->label('Tanggal Lahir'),
                Tables\Columns\TextColumn::make('age')->label('Umur'), // Use the accessor
                Tables\Columns\TextColumn::make('status_riwayat_diklat')->label('Riwayat Diklat'),
                Tables\Columns\TextColumn::make('pangkat')->label('Pangkat'),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('unit')->label('Unit'),
                Tables\Columns\TextColumn::make('surat')->label('Surat'),
                Tables\Columns\TextColumn::make('angkatan')->label('Angkatan'),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),
                // Tables\Columns\TextColumn::make('keterangan_2')->label('Keterangan 2'),
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
