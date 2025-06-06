<?php

namespace App\Filament\Resources\ReadyForDeliveryResource\Pages;

use App\Filament\Resources\ReadyForDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReadyForDeliveries extends ListRecords
{
    protected static string $resource = ReadyForDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
