<?php

namespace App\Filament\Resources\PesananResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    // ⚠️ HARUS SAMA dengan nama relasi di model Pesanan
    protected static string $relationship = 'details';

    protected static ?string $title = 'Detail Item Pesanan';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menu.nama')
                    ->label('Menu'),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Qty'),

                Tables\Columns\TextColumn::make('menu.harga')
                    ->label('Harga')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR'),
            ])
            
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
