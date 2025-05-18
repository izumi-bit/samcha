<?php

namespace App\Observers;

use App\Models\employee;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;

class EmployeeObserver
{
    /**
     * Handle the employee "created" event.
     */
    public function created(employee $employee): void
    {
           Record::create([
        'user_id' => Auth::id(), // logs the currently logged-in user
        'action' => 'Created Employee',
        'description' => 'Employee ' . $employee->first_name . ' was created.',
        'ip_address' => request()->ip(),
    ]);
    }

    /**
     * Handle the employee "updated" event.
     */
    public function updated(employee $employee): void
    {
           Record::create([
        'user_id' => Auth::id(),
        'action' => 'Updated Employee',
        'description' => 'Employee ' . $employee->first_name . ' was updated.',
        'ip_address' => request()->ip(),
    ]);
    }

    /**
     * Handle the employee "deleted" event.
     */
    public function deleted(employee $employee): void
    {
        //
    }

    /**
     * Handle the employee "restored" event.
     */
    public function restored(employee $employee): void
    {
        //
    }

    /**
     * Handle the employee "force deleted" event.
     */
    public function forceDeleted(employee $employee): void
    {
        //
    }
}
