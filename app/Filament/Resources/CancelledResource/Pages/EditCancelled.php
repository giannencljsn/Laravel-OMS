<?php

namespace App\Filament\Resources\CancelledResource\Pages;

use App\Filament\Resources\CancelledResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCancelled extends EditRecord
{
    protected static string $resource = CancelledResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
