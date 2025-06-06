<?php

namespace App\Filament\Resources\ReadyForPickupResource\Pages;

use App\Filament\Resources\ReadyForPickupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReadyForPickups extends ListRecords
{
    protected static string $resource = ReadyForPickupResource::class;

    protected function getHeaderActions(): array
    {
        return [
           
        ];
    }
}
