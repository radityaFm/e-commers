<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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
                        FileUpload::make('thumbnail')
                            ->label('Product Image')
                            ->image()
                            ->disk('public')
                            ->directory('product')
                            ->required(),
                        Repeater::make('photos')
                            ->relationship('photos')
                            ->schema([
                                FileUpload::make('photo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('product')
                                    ->required(),
                            ]),
                            Select::make('price')
                            ->label('price')
                            ->required()
                            ->options([
                                '3000' => '3000',
                                '5000' => '5000',
                                '6000' => '6000',
                                '8500' => '8500',
                                '10000' => '10000',
                            ])
                            ->position('bottom'), // Dropdown selalu buka ke bawah
                    ]),
                        TextInput::make('stock')
                            ->label('Stock')
                            ->prefix('Qty')
                            ->required()
                            ->placeholder('Enter the product stock'),
                        TextInput::make('slug')
                            ->hiddenOn(['create', 'edit'])
                            ->dehydrated(false),
                            Repeater::make('sizes')
                ->schema([
                    Select::make('size')
                        ->label('Size')
                        ->required()
                        ->options([
                            '4cm' => '4cm',
                            '6cm' => '6cm',
                            '8cm' => '8cm',
                            '10cm' => '10cm',
                            '12cm' => '12cm',
                            '14cm' => '14cm',
                            '16cm' => '16cm',
                        ])
                        ->position('bottom'), // Dropdown selalu buka ke bawah
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
                                'Yogurt' => 'Yogurt',
                                'Susu Jeli' => 'Susu Jeli',
                            ]),
                        Select::make('is_popular')
                            ->label('Rating')
                            ->required()
                            ->options([
                                true => 'Popular',
                                false => 'Not Popular',
                            ]),
                        TextInput::make('brand_name')
                            ->label('Brand Name')
                            ->nullable(),
                        FileUpload::make('brand_logo')
                            ->label('Brand Logo')
                            ->image()
                            ->disk('public')
                            ->directory('brands')
                            ->nullable(),
                            
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
                TextColumn::make('brand_name')
                    ->label('Brand Name')
                    ->searchable(),
                ImageColumn::make('thumbnail')
                    ->label('Image')
                    ->defaultImageUrl('storage/product/{filename}')
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
                        'Yogurt' => 'Yogurt',
                        'Susu Jeli' => 'Susu Jeli',
                    ]),
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