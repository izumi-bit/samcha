<?php

namespace App\Observers;

use App\Models\Salary;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
class SalaryObserver
{
    /**
     * Handle the Salary "created" event.
     */
    public function created(Salary $salary): void
    {
            Record::create([
            'user_id' => Auth::id(),
            'action' => 'Created Salary',
            'description' => 'Salary entry created for employee ID ' . $salary->employee_id,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Salary "updated" event.
     */
    public function updated(Salary $salary): void
    {
          Record::create([
            'user_id' => Auth::id(),
            'action' => 'Updated Salary',
            'description' => 'Salary updated for employee ID ' . $salary->employee_id,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Salary "deleted" event.
     */
    public function deleted(Salary $salary): void
    {
        //
    }

    /**
     * Handle the Salary "restored" event.
     */
    public function restored(Salary $salary): void
    {
        //
    }

    /**
     * Handle the Salary "force deleted" event.
     */
    public function forceDeleted(Salary $salary): void
    {
        //
    }
}
