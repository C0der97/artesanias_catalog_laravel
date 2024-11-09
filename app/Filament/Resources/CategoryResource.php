<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationLabel = 'Categorías';
    protected static ?string $pluralModelLabel = 'Categorías';
    protected static ?string $modelLabel = 'Categoría';
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(100),
                    
                Textarea::make('description')
                    ->label('Descripción')
                    ->maxLength(500),
                    
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255),
                    
                Select::make('parent_id')
                    ->label('Categoría Padre')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->nullable()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable(),
                    
                TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(50),
                    
                TextColumn::make('parent.name')
                    ->label('Categoría Padre')
                    ->sortable(),
            ])
            ->filters([
                // Puedes agregar filtros aquí
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Puedes agregar relaciones adicionales aquí
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
