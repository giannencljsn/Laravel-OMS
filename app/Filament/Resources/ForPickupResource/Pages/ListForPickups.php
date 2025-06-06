<?php

namespace App\Filament\Resources\ForPickupResource\Pages;

use App\Filament\Resources\ForPickupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForPickups extends ListRecords
{
    protected static string $resource = ForPickupResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
