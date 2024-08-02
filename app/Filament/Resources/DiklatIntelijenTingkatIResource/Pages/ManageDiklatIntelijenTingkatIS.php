<?php

namespace App\Filament\Resources\DiklatIntelijenTingkatIResource\Pages;

use App\Filament\Resources\DiklatIntelijenTingkatIResource;
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
}
