<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->reactive()
                ->debounce(1000) // tunggu 1000ms (1 detik) setelah user berhenti mengetik
                ->afterStateUpdated(function ($state, callable $set) {
                    $slug = \Str::slug($state);
                    $set('slug', $slug);
                }),
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->preload()
                ->searchable(),
            TextInput::make('slug')
                ->required()
                ->disabled(),

            FileUpload::make('image')
                ->disk('public') // pastikan sesuai disk kamu
                ->directory('products')
                ->image()
                ->preserveFilenames()
                ->required(),

            Textarea::make('description')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('category.name')
                ->label('Category')
                ->sortable()
                ->searchable(),
                TextColumn::make('slug'),
                ImageColumn::make('image')->disk('public'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
