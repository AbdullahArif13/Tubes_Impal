<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanResource\Pages;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LaporanResource extends Resource
{
    // LAPORAN AMBIL DARI PESANAN
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationLabel = 'Laporan Penjualan';
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public static function table(Table $table): Table
    {
        return $table
            // HANYA PESANAN SELESAI
            ->modifyQueryUsing(
                fn (Builder $query) => $query->where('status', 'selesai')
            )

            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('id')
                    ->label('ID Pesanan'),

                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total')
                    ->money('IDR'),
            ])

            ->filters([
                Filter::make('periode')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn ($q, $date) => $q->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn ($q, $date) => $q->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])

            // LAPORAN = VIEW SAJA
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporans::route('/'),
        ];
    }

    // TIDAK BISA CREATE / EDIT / DELETE
    public static function canCreate(): bool
    {
        return false;
    }
}
