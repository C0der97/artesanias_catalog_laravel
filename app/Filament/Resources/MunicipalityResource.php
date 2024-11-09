<?php


namespace App\Filament\Resources;

use App\Filament\Resources\MunicipalityResource\Pages;
use App\Models\Municipality;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form; // Corregido
use Filament\Tables\Table; 
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class MunicipalityResource extends Resource
{
    protected static ?string $model = Municipality::class;

    protected static ?string $navigationLabel = 'Municipios';
    protected static ?string $pluralModelLabel = 'Municipios';
    protected static ?string $modelLabel = 'Municipio';
    protected static ?string $navigationIcon = 'heroicon-o-map';

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

                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Departamento')
                    ->required(),
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
                    
                TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(50),
                    
                TextColumn::make('department.name')
                    ->label('Departamento')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime(),
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
            'index' => Pages\ListMunicipalities::route('/'),
            'create' => Pages\CreateMunicipality::route('/create'),
            'edit' => Pages\EditMunicipality::route('/{record}/edit'),
        ];
    }
}
