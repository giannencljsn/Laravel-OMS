<?php

namespace App\Filament\Resources\AllDeliveryResource\Pages;

use App\Filament\Resources\AllDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAllDeliveries extends ListRecords
{
    protected static string $resource = AllDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
