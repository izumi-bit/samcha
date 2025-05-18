<?php

namespace App\Observers;


use App\Models\Payroll;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;

class PayrollObserver
{
    /**
     * Handle the Payroll "created" event.
     */
      public function created(Payroll $payroll): void
    {
        if ($userId = Auth::id()) {
            Record::create([
                'user_id' => $userId,
                'action' => 'Created Payroll',
                'description' => 'Payroll for employee ID' . $payroll->employee_id. ' was created.',
                'ip_address' => request()->ip(),
            ]);
        }
    }

    public function updated(Payroll $payroll): void
    {
        if ($userId = Auth::id()) {
            Record::create([
                'user_id' => $userId,
                'action' => 'Updated Payroll',
                'description' => 'Payroll for employee ID ' . $payroll->employee_id . ' was updated.',
                'ip_address' => request()->ip(),
            ]);
        }
    }

    /**
     * Handle the Payroll "deleted" event.
     */
    public function deleted(Payroll $payroll): void
    {
        //
    }

    /**
     * Handle the Payroll "restored" event.
     */
    public function restored(Payroll $payroll): void
    {
        //
    }

    /**
     * Handle the Payroll "force deleted" event.
     */
    public function forceDeleted(Payroll $payroll): void
    {
        //
    }
}
