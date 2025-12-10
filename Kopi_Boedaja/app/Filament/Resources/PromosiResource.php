<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromosiResource\Pages;
use App\Filament\Resources\PromosiResource\RelationManagers;
use App\Models\Promosi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromosiResource extends Resource
{
    protected static ?string $model = Promosi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('tipe')
                    ->options([
                        'percent' => 'Persentase',
                        'fixed'   => 'Potongan Tetap',
                        'b1g1'    => 'Beli X Dapat Y',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('nilai')
                    ->label('Nilai (persen atau nominal)')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('maks_potongan')
                    ->label('Maks Potongan (untuk persen)')
                    ->numeric()
                    ->visible(fn ($get) => $get('tipe') === 'percent'),

                Forms\Components\TextInput::make('buy_x')->visible(fn ($get) => $get('tipe') === 'b1g1'),
                Forms\Components\TextInput::make('get_y')->visible(fn ($get) => $get('tipe') === 'b1g1'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromosis::route('/'),
            'create' => Pages\CreatePromosi::route('/create'),
            'edit' => Pages\EditPromosi::route('/{record}/edit'),
        ];
    }
}
