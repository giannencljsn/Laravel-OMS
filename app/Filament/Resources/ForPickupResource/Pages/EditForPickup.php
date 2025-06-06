<?php

namespace App\Filament\Resources\ForPickupResource\Pages;

use App\Filament\Resources\ForPickupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForPickup extends EditRecord
{
    protected static string $resource = ForPickupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
