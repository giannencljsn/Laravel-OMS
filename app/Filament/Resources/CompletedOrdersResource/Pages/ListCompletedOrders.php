<?php

namespace App\Filament\Resources\CompletedOrdersResource\Pages;

use App\Filament\Resources\CompletedOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompletedOrders extends ListRecords
{
    protected static string $resource = CompletedOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
