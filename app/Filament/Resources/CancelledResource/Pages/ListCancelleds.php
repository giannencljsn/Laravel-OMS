<?php

namespace App\Filament\Resources\CancelledResource\Pages;

use App\Filament\Resources\CancelledResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCancelleds extends ListRecords
{
    protected static string $resource = CancelledResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
