<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Schedule;

class EmployeeCalendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static string $view = 'filament.pages.employee-calendar';
    protected static ?string $navigationGroup = 'Employees';

    protected function getViewData(): array
    {
        return [
            'events' => json_encode($this->getEvents()),
        ];
    }

    protected function getEvents(): array
    {
        return Schedule::all()->map(function ($schedule) {
            return [
                'title' => $schedule->name,
                'start' => $schedule->date . 'T' . $schedule->start_time,
                'end' => $schedule->date . 'T' . $schedule->end_time,
            ];
        })->toArray();
    }
}
