<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'first_name')
                    ->required(),
                Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->default(now())
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')
                    ->label('Employee'),
                TextColumn::make('department.name')
                    ->label('Department'),
                TextColumn::make('date'),
                TextColumn::make('time_in'),
                TextColumn::make('time_out'),
              BadgeColumn::make('status')
    ->label('Status')
    ->colors([
        'success' => fn ($state) => in_array($state, ['on time', 'undertime']),
        'danger' => fn ($state) => in_array($state, ['late', 'late and undertime', 'absent']),
    ])
    ->icons([
        'heroicon-o-check-circle' => 'on time',
        'heroicon-o-exclamation-circle' => fn ($state) => in_array($state, ['late', 'undertime', 'late and undertime']),
        'heroicon-o-x-circle' => 'absent',
    ])
    ->sortable()
    ->searchable(),

            ])
            ->actions([
    Tables\Actions\Action::make('Time In')
        ->action(function ($record) {
            $now = now();
            $officialEnd = now()->setTime(12, 55);

            if ($now->greaterThan($officialEnd)) {
                $record->update([
                    'status' => 'absent',
                ]);
                return;
            }

            $record->update([
                'time_in' => $now->format('H:i:s'),
            ]);
        })
        ->hidden(function ($record) {
            $now = now()->format('H:i:s');
            $officialEnd = '12:55:00';

            return filled($record->time_in) || $now > $officialEnd || $record->status === 'absent';
        }),

    Tables\Actions\Action::make('Time Out')
        ->action(function ($record) {
            $record->update([
                'time_out' => now()->format('H:i:s'),
            ]);
        })
        ->hidden(function ($record) {
            return blank($record->time_in) || filled($record->time_out);
        }),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
