<?php

namespace App\Filament\Resources\DiklatIntelijenTingkatIIResource\Pages;

use App\Filament\Resources\DiklatIntelijenTingkatIIResource;
use App\Filament\Widgets\HasilDiklatIntelijenTingkatIIWidget;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDiklatIntelijenTingkatIIS extends ManageRecords
{
    protected static string $resource = DiklatIntelijenTingkatIIResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            HasilDiklatIntelijenTingkatIIWidget::make(),
        ];
        
    }
}
