<?php

namespace App\Filament\Resources\ProductTransactionResource\Pages;

use App\Filament\Resources\ProductTransactionResource\Pages;
use App\Filament\Resources\ProductTransactionResource\RelationManagers;
use App\Models\ProductTransaction;
use App\Models\Product;
use App\Models\User;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;



class ProductTransactionResource extends Resource
{
    protected static ?string $model = ProductTransaction::class;

    protected static ?string $navigationLabel = 'Transaction';
    
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Management';

    protected static ?string $label = 'Transaction';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product and Price')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Select::make('product_id')
                                        ->relationship('product', 'name')
                                        ->label('Product')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $product = Product::find($state);
                                            $price = $product ? $product->price : 0;
                                            $quantity = $get('quantity') ?? 1;
                                            $subTotalAmount = $price * $quantity;
    
                                            $set('price', $price);
                                            $set('sub_total_amount', $subTotalAmount);
    
                                            $discount = $get('discount_amount') ?? 0;
                                            $grandTotalAmount = $subTotalAmount - $discount;
                                            $set('grand_total_amount', $grandTotalAmount);
    
                                            $sizes = $product ? $product->sizes->pluck('size', 'id')->toArray() : [];
                                            $set('sizes', $sizes);
                                        })
                                        ->afterStateHydrated(function ($state, callable $get, callable $set) {
                                            if ($state) {
                                                $product = Product::find($state);
                                                $sizes = $product ? $product->sizes->pluck('size', 'id')->toArray() : [];
                                                $set('sizes', $sizes);
                                            }
                                        }),
                                    Select::make('size')
                                        ->label('Size')
                                        ->options(function (callable $get) {
                                            $sizes = $get('sizes');
                                            return is_array($sizes) ? $sizes : [];
                                        })
                                        ->required()
                                        ->live(),
                                    TextInput::make('quantity')
                                        ->required()
                                        ->numeric()
                                        ->prefix('Qty')
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $price = $get('price');
                                            $quantity = $state;
                                            $subTotalAmount = $price * $quantity;
    
                                            $set('sub_total_amount', $subTotalAmount);
    
                                            $discount = $get('discount_amount') ?? 0;
                                            $grandTotalAmount = $subTotalAmount - $discount;
                                            $set('grand_total_amount', $grandTotalAmount);
                                        }),
                                    Select::make('promo_code_id')
                                        ->relationship('promoCode', 'code')
                                        ->searchable()
                                        ->preload()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $subTotalAmount = $get('sub_total_amount');
                                            $promoCode = PromoCode::find($state);
                                            $discount = $promoCode ? $promoCode->discount_amount : 0;
    
                                            $set('discount_amount', $discount);
    
                                            $grandTotalAmount = $subTotalAmount - $discount;
                                            $set('grand_total_amount', $grandTotalAmount);
                                        }),
                                    TextInput::make('sub_total_amount')
                                        ->label('Sub Total')
                                        ->required()
                                        ->numeric()
                                        ->prefix('IDR'),
                                    TextInput::make('grand_total_amount')
                                        ->label('Total')
                                        ->required()
                                        ->numeric()
                                        ->prefix('IDR'),
                                    TextInput::make('discount_amount')
                                        ->readOnly()
                                        ->numeric()
                                        ->prefix('IDR'),
                                ]),
                        ]),
                    Step::make('Information User') 
                    ->schema([
                        TextInput::make('user_id')
                            ->default(auth()->id()) 
                            ->hidden(),
                        TextInput::make('name')
                            ->default(auth()->user()->name) 
                            ->readonly(), 
                        TextInput::make('phone_number')
                            ->default(auth()->user()->phone_number),
                        TextInput::make('city')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('address')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('post_code')
                            ->required()
                            ->numeric()
                            ->maxLength(255),
                    ]),

                    Step::make('Payment')
                        ->schema([
                            TextInput::make('booking_trx_id')
                                ->required()
                                ->maxLength(255),
                            ToggleButtons::make('is_paid')
                                ->label('Payment Status')
                                ->boolean()
                                ->grouped()
                                ->options([
                                    true => 'Paid',
                                    false => 'Unpaid',
                                ])
                                ->required(),
                            FileUpload::make('proof')
                                ->image()
                                ->requiredIf('is_paid', true),
                        ]),
                ])
                ->columnSpan('full')
                ->columns(1)
                ->skippable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('product.thumbnail'),
                TextColumn::make('user.name') 
                ->label('User Name')
                ->searchable(),
                TextColumn::make('booking_trx_id')
                    ->label('Booking ID')
                    ->searchable(),
                BooleanColumn::make('is_paid')
                    ->label('Status')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

            ])
            ->filters([
                SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (ProductTransaction $productTransaction) {
                        $productTransaction->update([
                            'is_paid' => true,
                        ]); 

                        Notification::make()
                            ->title('Payment Approved')
                            ->success()
                            ->body('Payment has been approved')
                            ->send();
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (ProductTransaction $productTransaction) => !$productTransaction->is_paid),
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
            'index' => Pages\ListProductTransactions::route('/'),
            'create' => Pages\CreateProductTransaction::route('/create'),
            'edit' => Pages\EditProductTransaction::route('/{record}/edit'),
        ];
    }
}
