<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('nama')
                ->helperText('Masukkan nama menu')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('deskripsi')
                ->helperText('Masukkan deskripsi menu')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('harga')
                ->helperText('Masukkan nama menu')
                ->numeric(),

                Forms\Components\FileUpload::make('gambar_produk')
                ->image()
                ->required(),

                Forms\Components\TextInput::make('kategori')
                ->helperText('Masukkan kategori menu')
                ->required(),
                
                Forms\Components\Toggle::make('tersedia')
                ->helperText('Apakah menu tersedia?')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('nama')
                ->searchable(),

                Tables\Columns\TextColumn::make('harga')
                ->money('idr'),

                Tables\Columns\TextColumn::make('kategori'),

                Tables\Columns\BooleanColumn::make('tersedia')
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
