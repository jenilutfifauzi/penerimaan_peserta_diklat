<?php

namespace App\Filament\Resources\KepemimpinanAdministratorResource\Pages;

use App\Filament\Resources\KepemimpinanAdministratorResource;
use App\Filament\Widgets\HasilKepemimpinanAdministratorWidget;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKepemimpinanAdministrators extends ManageRecords
{
    protected static string $resource = KepemimpinanAdministratorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            HasilKepemimpinanAdministratorWidget::make(),
        ];
        
    }
}
