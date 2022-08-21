<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\Fieldset;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Product Details')
                    ->schema([
                        Forms\Components\MultiSelect::make('categories')
                            ->relationship('categories', 'name'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Product Name')
                            ->reactive()
                            ->afterStateUpdated(function ($set, $state, $context) {
                                if ($context === 'edit') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->rules(['alpha_dash'])
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('SKU')
                            ->maxLength(255)
                            ->required()
                            ->label('SKU'),
                        Forms\Components\MarkdownEditor::make('description')
                            ->maxLength(65535),
                        Forms\Components\TextInput::make('actual_price')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->decimalPlaces(2)
                            ),
                        Forms\Components\TextInput::make('selling_price')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->decimalPlaces(2)
                            ),
                        Forms\Components\TextInput::make('shipping_charges')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->decimalPlaces(2)
                            ),
                        Forms\Components\TextInput::make('stock')
                            ->required()
                            ->numeric(),
                        Forms\Components\Toggle::make('status')
                            ->required(),
                    ]),
                Fieldset::make('Product Gallery')
                    ->schema([

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('SKU'),
                Tables\Columns\TextColumn::make('stock'),
                Tables\Columns\BooleanColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
