<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Department;
use App\Observers\DepartmentObserver;
use App\Models\Payroll;
use App\Observers\PayrollObserver;
use App\Models\Employee;
use App\Observers\EmployeeObserver;
use App\Models\Salary;
use App\Observers\SalaryObserver;
use App\Models\Attendance;
use App\Observers\AttendanceObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        User::observe(UserObserver::class);
        Department::observe(DepartmentObserver::class);
          Payroll::observe(PayrollObserver::class);
              Employee::observe(EmployeeObserver::class);
               Salary::observe(SalaryObserver::class);
                   Attendance::observe(AttendanceObserver::class);
    }

    
}