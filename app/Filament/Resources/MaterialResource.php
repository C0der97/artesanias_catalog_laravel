<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Models\Material;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Toggle;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationLabel = 'Materiales';
    protected static ?string $pluralModelLabel = 'Materiales';
    protected static ?string $modelLabel = 'Material';
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Material')
                    ->description('Ingrese la información básica del material')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Ej: Madera, Cuero, Cerámica'),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->maxLength(500)
                            ->placeholder('Breve descripción del material'),

                        Toggle::make('is_active')
                            ->label('¿Está activo?')
                            ->default(true)
                            ->helperText('Determina si este material está disponible para ser asignado a productos'),

                        TextInput::make('properties')
                            ->label('Propiedades')
                            ->placeholder('Ej: Resistente al agua, Flexible')
                            ->helperText('Propiedades específicas del material (opcional)')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(50)
                    ->searchable(),

                ToggleColumn::make('is_active')
                    ->label('Activo')
                    ->sortable(),

                TextColumn::make('properties')
                    ->label('Propiedades')
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}