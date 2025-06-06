<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Set pickup_code to a generated value if it's empty
        if (empty($data['pickup_code'])) {
            $data['pickup_code'] = OrderResource::generatePickupCode();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure pickup_code is saved with the generated value if it's still empty
        if (empty($data['pickup_code'])) {
            $data['pickup_code'] = OrderResource::generatePickupCode();
        }

        return $data;
    }
}
