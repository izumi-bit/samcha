<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Models\Salary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\CheckboxList; // add this at the top


class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('employee_id')
                ->label('Employee')
                ->relationship('employee', 'first_name')
                ->required(),

            TextInput::make('basic_salary')
                ->label('Basic Salary')
                ->numeric()
                ->required()
                ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('net_salary', ($state ?? 0) + ($get('allowances') ?? 0) - ($get('deductions') ?? 0))
                ),

            TextInput::make('allowances')
                ->label('Allowances')
                ->numeric()
                ->default(0)
                ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('net_salary', ($get('basic_salary') ?? 0) + ($state ?? 0) - ($get('deductions') ?? 0))
                ),

            TextInput::make('deductions')
                ->label('Deductions')
                ->numeric()
                ->default(0)
                ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('net_salary', ($get('basic_salary') ?? 0) + ($get('allowances') ?? 0) - ($state ?? 0))
                ),

                    CheckboxList::make('benefits')
            ->relationship('benefits', 'name')
            ->label('Benefit Deductions'),

            TextInput::make('net_salary')
                ->label('Net Salary')
                ->numeric()
                ->disabled()
                ->required(),

            DatePicker::make('salary_date')
                ->label('Salary Date')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')->label('Employee')->sortable()->searchable(),
            TextColumn::make('basic_salary')->label('Basic Salary')->money('PHP')->sortable(),

            TextColumn::make('allowances')
                ->label('Allowances')
                ->money('PHP')
                ->sortable(),

            TextColumn::make('total_benefits')
                ->label('Benefit Deductions')
                ->money('PHP')
                ->sortable(),

            TextColumn::make('deductions')
                ->label('Other Deductions')
                ->money('PHP')
                ->sortable(),

            TextColumn::make('net_salary')
                ->label('Net Salary (After Benefits)')
                ->money('PHP')
                ->sortable(),

            TextColumn::make('salary_date')->label('Salary Date')->date()->sortable(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }
}
