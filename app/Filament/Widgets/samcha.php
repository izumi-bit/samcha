<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\position;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class samcha extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users',User::count())
            ->description('NEW USERS')
            ->chart([5,10,20,30])
            ->color('informational '),

            Stat::make('Employee',Employee::count())
            ->description('NEW Employee')
            ->chart([5,10,20,30])
            ->color('informational '),

            Stat::make('Position',Position::count())
            ->description('NEW position')
            ->chart([5,10,20,30])
            ->color('informational '),

            Stat::make('Schedule',Schedule::count())
            ->description('NEW Schedule')
            ->chart([5,10,20,30])
            ->color('informational '),

            Stat::make('Stuent',Student::count())
            ->description('NEW Student')
            ->chart([5,10,20,30])
            ->color('informational '),

             Stat::make('Attendance',Attendance::count())
            ->description('EMPLOYEE TIME IN')
            ->chart([5,10,20,30])
            ->color('informational '),
          
        ];
    }
}
