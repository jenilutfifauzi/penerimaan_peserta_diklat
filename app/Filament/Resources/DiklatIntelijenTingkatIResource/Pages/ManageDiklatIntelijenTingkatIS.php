<?php

namespace App\Filament\Resources\DiklatIntelijenTingkatIResource\Pages;

use App\Filament\Resources\DiklatIntelijenTingkatIResource;
use App\Filament\Widgets\HasilDiklatIntelijenTingkatIWidget;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDiklatIntelijenTingkatIS extends ManageRecords
{
    protected static string $resource = DiklatIntelijenTingkatIResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            HasilDiklatIntelijenTingkatIWidget::make(),
        ];
        
    }
}
