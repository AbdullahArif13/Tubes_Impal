<?php

namespace App\Filament\Resources\PromosiResource\Pages;

use App\Filament\Resources\PromosiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPromosi extends EditRecord
{
    protected static string $resource = PromosiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
