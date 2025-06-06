<?php

namespace App\Filament\Resources\AllDeliveryResource\Pages;

use App\Filament\Resources\AllDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAllDelivery extends EditRecord
{
    protected static string $resource = AllDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
