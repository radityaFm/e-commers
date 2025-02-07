<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function getRecordRouteKeyName(): string
    {
        return 'slug'; // menggunakan slug pengganti id
    }
    
    protected static ?string $navigationLabel = 'Product';

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Management';

    protected static ?string $label = 'Product';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->placeholder('Enter the product name'),
                        Fileupload::make('thumbnail')
                            ->label('Product Image')
                                ->image()
                                ->required(),
                        Repeater::make('product_photo')
                                ->relationship('photos')
                                ->schema([
                                    FileUpload::make('photo')
                                        ->image()
                                        ->required(),
                                ]),
                        Repeater::make('sizes')
                                ->relationship('sizes')
                                ->schema([
                                    TextInput::make('size')
                                        ->nullable(),
                                ]),
                        TextInput::make('price')
                            ->label('Price')
                            ->required()
                            ->numeric()
                            ->prefix('IDR')
                            ->placeholder('Enter the product price'),
                        TextInput::make('stock')
                            ->label('Stock')
                            ->prefix('Qty')
                            ->required()
                            ->placeholder('Enter the product stock'),
                        TextInput::make('slug')
                            ->hiddenOn(['create', 'edit'])
                            ->dehydrated(false),
                    ]),
                Fieldset::make('Additional')
                    ->schema([
                        Textarea::make('about')
                            ->label('About')
                            ->required()
                            ->placeholder('Enter the product description'),
                        Select::make('category')
                            ->label('Category')
                            ->required()
                            ->options([
                                1 => 'Yogurt',
                                2 => 'susu jeli',
                            ]),
                        select::make('is_popular')
                            ->label('Rating')
                            ->required()
                            ->options([
                                true => 'Popular',
                                false => 'Not Popular',
                            ]),
                        select::make('brands_id')
                            ->label('Brand')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->searchable(),
                ImageColumn::make('thumbnail')
                    ->label('Image')
                    ->width(100)
                    ->height(100),
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(function ($state) {
                        return 'IDR ' . number_format($state, 0, ',', '.');
                }),
                TextColumn::make('stock')
                    ->label('Stock'),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Category')
                    ->options([
                        1 => 'Susu jeli',
                        2 => 'Yogurt',
                    ]),
                SelectFilter::make('brands_id')
                    ->label('Brand')
                    ->relationship('brand', 'name'),
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
            'index' => Pages\ListProduct::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
    