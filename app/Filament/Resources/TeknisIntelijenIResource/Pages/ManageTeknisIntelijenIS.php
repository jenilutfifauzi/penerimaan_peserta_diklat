<?php

namespace App\Filament\Resources\TeknisIntelijenIResource\Pages;

use App\Filament\Resources\TeknisIntelijenIResource;
use App\Filament\Widgets\HasilTeknisIntelijenI;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTeknisIntelijenIS extends ManageRecords
{
    protected static string $resource = TeknisIntelijenIResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            HasilTeknisIntelijenI::make(),
        ];
        
    }
}
