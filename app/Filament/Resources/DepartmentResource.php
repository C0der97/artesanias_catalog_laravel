<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationLabel = 'Departamentos';
    protected static ?string $pluralModelLabel = 'Departamentos';
    protected static ?string $modelLabel = 'Departamento';
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
