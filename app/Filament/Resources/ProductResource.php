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

                            Section::make('Imágenes del Producto')
                            ->schema([
                                FileUpload::make('images')
                                ->label('Imágenes')
                                ->multiple()
                                ->image()
                                ->directory('products')
                                ->visibility('public')
                                ->reorderable()
                                ->appendFiles()
                                ->maxFiles(5)
                                ->helperText('Sube hasta 5 imágenes. La primera será la principal.')
                                ->columnSpanFull()
                                ->afterStateUpdated(function ($set, $state, $context) use ($form) {
                                    // Solo ejecuta esto al crear un producto (no en el contexto de edición)
                                    if ($context === 'create' && $state && is_array($state)) {
                                        // Obtener el producto desde el formulario
                                        $product = $form->getRecord();
                            
                                        // Verificar si el producto es válido antes de continuar
                                        if ($product && !$product->exists) {
                                            // Guarda el producto primero (esto asegura que el producto tenga un ID)
                                            $product->save();  // Guarda el producto en la base de datos para obtener el ID
                                        }
                            
                                        // Ahora que tenemos un ID del producto, insertamos las imágenes
                                        if ($product && $product->exists) {
                                            $imagePaths = collect($state)->map(function ($path, $index) use ($product) {
                                                return [
                                                    'product_id' => $product->id,  // Asocia las imágenes con el ID del producto
                                                    'image_path' => $path,
                                                    'is_primary' => $index === 0, // La primera imagen será la principal
                                                    'created_at' => now(),
                                                    'updated_at' => now(),
                                                ];
                                            })->toArray();
                            
                                            // Inserta las imágenes en la base de datos
                                            $product->images()->insert($imagePaths);
                                        }
                                    }
                                })                                                    
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('productImages.image_path')
                    ->label('Imagen')
                    ->circular()
                    ->stacked()
                    ->limit(3),

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