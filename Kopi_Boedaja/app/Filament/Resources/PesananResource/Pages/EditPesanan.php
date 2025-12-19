<?php

namespace App\Filament\Resources\PesananResource\Pages;

use App\Filament\Resources\PesananResource;
use Filament\Resources\Pages\EditRecord;

class EditPesanan extends EditRecord
{
    protected static string $resource = PesananResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function handleRecordNotFound(): void
    {
        $this->notify('danger', 'Data pesanan tidak dapat dimuat.');
        $this->redirect($this->getRedirectUrl());
    }
}
