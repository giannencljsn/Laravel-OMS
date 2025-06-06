<?php

namespace App\Filament\Resources\PhonevilleBranchResource\Pages;

use App\Filament\Resources\PhonevilleBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhonevilleBranches extends ListRecords
{
    protected static string $resource = PhonevilleBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
