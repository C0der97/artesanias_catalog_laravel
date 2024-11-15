<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'Productos';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Section::make('Información Básica')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255),
                                    
                                Textarea::make('description')
                                    ->label('Descripción')
                                    ->maxLength(500),
                                    Select::make('materials')
                                    ->relationship('materials', 'name')
                                    ->multiple()
                                    ->label('Materiales utilizados'),
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->label('Categoría')
                                    ->required(),

                                Select::make('artisan_id')
                                    ->relationship('artisan', 'name')
                                    ->label('Artesano')
                                    ->required(),

                                TextInput::make('price')
                                    ->label('Precio')
                                    ->required()
                                    ->numeric()
                                    ->step(0.01)
                                    ->rules(['min:0', 'numeric', 'max:99999'])
                                    ->placeholder('0.00'),

                                TextInput::make('dimensions')
                                    ->label('Dimensiones')
                                    ->nullable(),

                                TextInput::make('weight')
                                    ->label('Peso')
                                    ->nullable(),

                                Checkbox::make('featured')
                                    ->label('Destacado')
                                    ->default(false),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255),
                            ])->columnSpan(1),

                            TextInput::make('image_url')
                            ->required()
                            ->label('Image URL')
                            ->url()
                            ->placeholder('https://example.com/image.jpg'),
             
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image_url')->label('Image URL'),
                ImageColumn::make('image_url')->label('Product Image'),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->sortable(),
                    
                TextColumn::make('artisan.name')
                    ->label('Artesano')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Precio')
                    ->sortable(),

                TextColumn::make('featured')
                    ->label('Destacado')
                    ->sortable(),
    
                    TextColumn::make('materials.name')
                    ->label('Materiales utilizados')
                    ->formatStateUsing(function ($state) {
                        if ($state instanceof \Illuminate\Support\Collection) {
                            return $state->pluck('name')->join(', ');
                        }
                
                        return $state ? implode(', ', (array) $state) : 'N/A';
                    }),
                


            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Categoría')
                    ->options(Category::all()->pluck('name', 'id')->toArray())
            ]);
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