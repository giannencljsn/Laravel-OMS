<?php

namespace App\Filament\Resources\InactiveUserResource\Pages;

use App\Filament\Resources\InactiveUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInactiveUsers extends ListRecords
{
    protected static string $resource = InactiveUserResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
