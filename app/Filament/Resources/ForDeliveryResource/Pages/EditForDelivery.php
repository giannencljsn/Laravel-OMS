<?php

namespace App\Filament\Resources\ForDeliveryResource\Pages;

use App\Filament\Resources\ForDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForDelivery extends EditRecord
{
    protected static string $resource = ForDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
