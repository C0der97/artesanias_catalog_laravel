<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtisanResource\Pages;
use App\Models\Artisan;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form; // Import correcto
use Filament\Tables\Table; // Import correcto
use Filament\Tables\Columns\TextColumn; // Importación para TextColumn
use Filament\Tables\Filters\SelectFilter; // Importación para SelectFilter

class ArtisanResource extends Resource
{
    protected static ?string $model = Artisan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Catalogo';
    protected static ?string $navigationLabel = 'Artesanos';
    protected static ?string $pluralModelLabel = 'Artesanos';
    protected static ?string $modelLabel = 'Artesano';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nombre del artesano'),
                
                Forms\Components\Textarea::make('biography')
                    ->label('Biografía'),
                
                Forms\Components\Select::make('municipality_id')
                    ->relationship('municipality', 'name')
                    ->required()
                    ->label('Municipio'),
                
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono'),
                
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('Correo electrónico'),
                
                Forms\Components\Textarea::make('address')
                    ->label('Dirección'),
                
                Forms\Components\Toggle::make('featured')
                    ->label('Destacado')
                    ->default(false),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Activo',
                        'inactive' => 'Inactivo',
                    ])
                    ->default('active')
                    ->label('Estado'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('municipality.name')
                    ->label('Municipio')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\BooleanColumn::make('featured')
                    ->label('Destacado')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Fecha de creación'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Activo',
                        'inactive' => 'Inactivo',
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
            'index' => Pages\ListArtisans::route('/'),
            'create' => Pages\CreateArtisan::route('/create'),
            'edit' => Pages\EditArtisan::route('/{record}/edit'),
        ];
    }
}
