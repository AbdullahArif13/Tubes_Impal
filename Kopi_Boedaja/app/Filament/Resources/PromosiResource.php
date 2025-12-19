<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromosiResource\Pages;
use App\Models\Promosi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PromosiResource extends Resource
{
    protected static ?string $model = Promosi::class;

    protected static ?string $navigationLabel = 'Manajemen Promosi';
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_promosi')
                ->label('Nama Promosi')
                ->required(),

            Forms\Components\Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->required(),

            Forms\Components\Select::make('tipe')
                ->label('Tipe Promo')
                ->options([
                    'percent' => 'Persentase (%)',
                    'fixed'   => 'Potongan Tetap',
                    'b1g1'    => 'Beli X Dapat Y',
                ])
                ->reactive()
                ->required(),

            Forms\Components\TextInput::make('nilai')
                ->label('Nilai Diskon')
                ->numeric()
                ->required()
                ->required(fn ($get) => in_array($get('tipe'), ['percent', 'fixed']))
                ->visible(fn ($get) => in_array($get('tipe'), ['percent', 'fixed'])),

            Forms\Components\TextInput::make('maks_potongan')
                ->label('Maks Potongan')
                ->numeric()
                ->visible(fn ($get) => $get('tipe') === 'percent'),

            Forms\Components\TextInput::make('buy_x')
                ->label('Beli (X)')
                ->numeric()
                ->required(fn ($get) => $get('tipe') === 'b1g1')
                ->visible(fn ($get) => $get('tipe') === 'b1g1'),

            Forms\Components\TextInput::make('get_y')
                ->label('Gratis (Y)')
                ->numeric()
                ->required(fn ($get) => $get('tipe') === 'b1g1')
                ->visible(fn ($get) => $get('tipe') === 'b1g1'),

            Forms\Components\DatePicker::make('tanggal_berlaku')
                ->label('Tanggal Mulai')
                ->required(),

            Forms\Components\DatePicker::make('tanggal_berakhir')
                ->label('Tanggal Berakhir')
                ->required(),

            Forms\Components\Toggle::make('aktif')
                ->label('Promo Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_promosi')
                    ->label('Nama Promo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tipe')
                    ->label('Tipe'),

                Tables\Columns\TextColumn::make('nilai')
                    ->label('Nilai'),

                Tables\Columns\TextColumn::make('tanggal_berlaku')
                    ->label('Mulai')
                    ->date(),

                Tables\Columns\TextColumn::make('tanggal_berakhir')
                    ->label('Berakhir')
                    ->date(),

                Tables\Columns\IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPromosis::route('/'),
            'create' => Pages\CreatePromosi::route('/create'),
            'edit'   => Pages\EditPromosi::route('/{record}/edit'),
        ];
    }
}
