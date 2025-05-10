<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    public static function canEdit(Model $record): bool
    {
        return Filament::getCurrentPanel()?->getId()!=='user';
    }

    public static function canCreate(): bool
    {
        return Filament::getCurrentPanel()?->getId()!=='user';
    }

    public static function canDelete(Model $record): bool
    {
        return Filament::getCurrentPanel()?->getId()!=='user';
    }

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Employee Info')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Essential Information')
                            ->schema([
                                TextInput::make('first_name')
                                    ->required(),
                                TextInput::make('middle_name')
                                    ->nullable(),
                                TextInput::make('last_name')
                                    ->required(),
                                TextInput::make('age')
                                    ->numeric()
                                    ->nullable(),
                                Select::make('status')
                                    ->default('active')
                                    ->options([
                                        'single' => 'Single',
                                        'married' => 'Married',
                                    ])->required(),
                            ]),
                        Tab::make('Online Information')
                            ->schema([
                                FileUpload::make('cv')
                                    ->label('CV')
                                    ->nullable()
                                    ->directory('uploads/cvs') // Store in a separate folder
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(2048), // Max 2MB
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('middle_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('last_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('age')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('cv')
                    ->label('CV')
                    ->url(fn (Employee $record) => asset('storage/uploads/cvs/' . $record->cv), true),
                Tables\Columns\TextColumn::make('salary.net_salary')
                    ->label('Basic Salary')
                    ->money('PHP'),

                // Display payroll status
                TextColumn::make('latest_payroll_status')
                    ->label('Payroll Status')
                    ->getStateUsing(function ($record) {
                        $latestPayroll = $record->payrolls()->latest()->first();
                        return $latestPayroll ? $latestPayroll->status : 'No payroll record';
                    }),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
