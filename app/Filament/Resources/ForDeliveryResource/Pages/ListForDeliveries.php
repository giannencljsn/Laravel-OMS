<?php

namespace App\Filament\Resources\ForDeliveryResource\Pages;

use App\Filament\Resources\ForDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForDeliveries extends ListRecords
{
    protected static string $resource = ForDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
