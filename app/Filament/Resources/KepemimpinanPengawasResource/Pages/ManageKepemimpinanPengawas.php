<?php

namespace App\Filament\Resources\KepemimpinanPengawasResource\Pages;

use App\Filament\Resources\KepemimpinanPengawasResource;
use App\Filament\Widgets\HasilKepemimpinanPengawasWidget;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKepemimpinanPengawas extends ManageRecords
{
    protected static string $resource = KepemimpinanPengawasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            HasilKepemimpinanPengawasWidget::make(),
        ];
        
    }
}
