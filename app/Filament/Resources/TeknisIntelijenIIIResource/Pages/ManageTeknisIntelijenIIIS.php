<?php

namespace App\Filament\Resources\TeknisIntelijenIIIResource\Pages;

use App\Filament\Resources\TeknisIntelijenIIIResource;
use App\Filament\Widgets\HasilTeknisIntelijenIII;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTeknisIntelijenIIIS extends ManageRecords
{
    protected static string $resource = TeknisIntelijenIIIResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            HasilTeknisIntelijenIII::make(),
        ];
        
    }
}
