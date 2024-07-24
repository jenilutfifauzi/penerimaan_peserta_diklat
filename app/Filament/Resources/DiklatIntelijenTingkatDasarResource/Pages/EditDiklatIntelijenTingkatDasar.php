<?php

namespace App\Filament\Resources\DiklatIntelijenTingkatDasarResource\Pages;

use App\Filament\Resources\DiklatIntelijenTingkatDasarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiklatIntelijenTingkatDasar extends EditRecord
{
    protected static string $resource = DiklatIntelijenTingkatDasarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
