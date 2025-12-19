<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pesanan';
    protected static ?string $pluralLabel = 'Pesanan';
    protected static ?string $modelLabel = 'Pesanan';

    /**
     * ======================
     * FORM (DETAIL PESANAN)
     * ======================
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pelanggan_id')
                    ->label('Pelanggan')
                    ->disabled()
                    ->formatStateUsing(fn ($state) => $state ?? 'Guest'),

                Forms\Components\TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->numeric()
                    ->disabled(),

                Forms\Components\Select::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending'   => 'Pending',
                        'diproses'  => 'Diproses',
                        'selesai'   => 'Selesai',
                    ])
                    ->required(),
            ]);
    }

    /**
     * ======================
     * TABLE (DAFTAR PESANAN)
     * ======================
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pelanggan_id')
                    ->label('Pelanggan')
                    ->formatStateUsing(fn ($state) => $state ?? 'Guest'),

                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info'    => 'diproses',
                        'success' => 'selesai',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Detail / Ubah Status')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Perubahan Status')
                    ->modalDescription('Apakah Anda yakin ingin mengubah status pesanan ini?'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus Pesanan')
                    ->requiresConfirmation(),
            ])
            ->defaultSort('created_at', 'desc');
    }


    /**
     * ======================
     * RELATIONS
     * ======================
     */
    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\PesananResource\RelationManagers\DetailsRelationManager::class,
        ];
    }


    /**
     * ======================
     * PAGES
     * ======================
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            'edit'  => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }

    /**
     * ======================
     * DISABLE CREATE
     * ======================
     */
    public static function canCreate(): bool
    {
        return false;
    }
}
