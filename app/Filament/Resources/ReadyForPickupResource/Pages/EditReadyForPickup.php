<?php

namespace App\Filament\Resources\ReadyForPickupResource\Pages;

use App\Filament\Resources\ReadyForPickupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReadyForPickup extends EditRecord
{
    protected static string $resource = ReadyForPickupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
