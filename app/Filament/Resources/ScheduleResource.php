<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-office';

 ///   public static function canCreate(): bool
   // {
   //     return Filament::getCurrentPanel()?->getId() !== 'user';
    //}

   // public static function canEdit(Model $record): bool
  ///  {
   //     return Filament::getCurrentPanel()?->getId() !== 'user';
   // }

   // public static function canDelete(Model $record): bool
  //  {
   //     return Filament::getCurrentPanel()?->getId() !== 'user';
   // }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('employee_id')
                ->label('Employee')
                ->relationship('employee', 'first_name')
               
                ->required(),

            TextInput::make('name')
                ->label('Schedule Name')
                ->required(),

            Select::make('type')
                ->label('Schedule Type')
                ->options([
                    'Work Shift' => 'Work Shift',
                    'Meeting' => 'Meeting',
                    'Salary Day' => 'Salary Day',
                ])
                ->required(),

            DatePicker::make('date')
                ->required(),

            TimePicker::make('start_time')
                ->label('Start Time')
                ->required(),

            TimePicker::make('end_time')
                ->label('End Time')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
    if (Filament::getCurrentPanel()?->getId() === 'user') {
        $employeeId = Filament::auth()?->user()?->employee?->id;

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        } else {
            $query->whereRaw('0 = 1'); // Avoid returning anything if no employee
        }
    }

            })
            ->columns([
                TextColumn::make('employee.first_name')
                    ->label('Employee')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Schedule Name'),

                TextColumn::make('type')
                    ->label('Type'),

                TextColumn::make('date')
                    ->label('Date')
                    ->date(),

                TextColumn::make('start_time')
                    ->label('Start'),

                TextColumn::make('end_time')
                    ->label('End'),
                    Tables\Columns\TextColumn::make('employee.schedule.type')
            ->label('Schedule'),
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
