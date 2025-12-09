<?php

namespace App\Filament\Resources\PromosiResource\Pages;

use App\Filament\Resources\PromosiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPromosis extends ListRecords
{
    protected static string $resource = PromosiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
