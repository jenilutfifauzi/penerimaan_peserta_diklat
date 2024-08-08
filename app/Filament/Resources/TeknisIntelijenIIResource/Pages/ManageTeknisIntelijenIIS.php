<?php

namespace App\Filament\Resources\TeknisIntelijenIIResource\Pages;

use App\Filament\Resources\TeknisIntelijenIIResource;
use App\Filament\Widgets\HasilTeknisIntelijenII;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTeknisIntelijenIIS extends ManageRecords
{
    protected static string $resource = TeknisIntelijenIIResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            HasilTeknisIntelijenII::make(),
        ];
        
    }
}
