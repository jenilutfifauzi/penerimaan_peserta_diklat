<?php

namespace App\Filament\Resources\DiklatIntelijenTingkatDasarResource\Pages;

use App\Filament\Resources\DiklatIntelijenTingkatDasarResource;
use App\Filament\Widgets\HasilDiklatIntelijenTingkatDasarWidget;
use App\Models\DiklatIntelijenTingkatDasar;
use Filament\Infolists\Infolist;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ListRecords;

class ListDiklatIntelijenTingkatDasars extends ListRecords
{
    protected static string $resource = DiklatIntelijenTingkatDasarResource::class;
    protected static ?string $title = 'Diklat Intelijen Tingkat Dasar';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nama'] = auth()->id();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            HasilDiklatIntelijenTingkatDasarWidget::make(),
        ];
        
    }
}
