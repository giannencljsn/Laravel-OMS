<?php

namespace App\Filament\Resources\AllPickupOrdersResource\Pages;

use App\Filament\Resources\AllPickupOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAllPickupOrders extends ListRecords
{
    protected static string $resource = AllPickupOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
       
        ];
    }
}
