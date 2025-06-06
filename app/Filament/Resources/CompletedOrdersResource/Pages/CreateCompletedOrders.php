<?php

namespace App\Filament\Resources\CompletedOrdersResource\Pages;

use App\Filament\Resources\CompletedOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompletedOrders extends CreateRecord
{
    protected static string $resource = CompletedOrdersResource::class;
}
