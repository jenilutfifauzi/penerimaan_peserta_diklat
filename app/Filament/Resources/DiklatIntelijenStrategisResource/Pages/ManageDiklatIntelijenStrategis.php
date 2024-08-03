<?php

namespace App\Filament\Resources\DiklatIntelijenStrategisResource\Pages;

use App\Filament\Resources\DiklatIntelijenStrategisResource;
use App\Filament\Widgets\HasilDiklatIntelijenStrategisWidget;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDiklatIntelijenStrategis extends ManageRecords
{
    protected static string $resource = DiklatIntelijenStrategisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            HasilDiklatIntelijenStrategisWidget::make(),
        ];
        
    }
}
