<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Select::make('user_id')
                    ->label('Customer')
                    ->relationship('user', 'name') // Relasi ke user
                    ->searchable()
                    ->default(fn () => auth()->id()) // Ambil user yang sedang login
                    ->disabled(),
                
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                
                Textarea::make('notes')
                    ->label('Notes')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                    TextColumn::make('user.name') // Pastikan relasi benar
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->default('Guest'), 

                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                
                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->date(),
                
                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('IDR')
                    ->sortable()
                    ->getStateUsing(fn (Order $record) => optional($record->items)->sum(fn($item) => $item->quantity * $item->price)),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
