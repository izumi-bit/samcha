<?php

namespace App\Observers;

use App\Models\Department;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;

class DepartmentObserver
{
    /**
     * Handle the Department "created" event.
     */
    public function created(Department $department): void
    {
            if ($userId = Auth::id()) {
            Record::create([
                'user_id' => $userId,
                'action' => 'Created Department',
                'description' => 'Department ' . $department->name . ' was created.',
                'ip_address' => request()->ip(),
            ]);
        }
    }

    /**
     * Handle the Department "updated" event.
     */
    public function updated(Department $department): void
    {
          if ($userId = Auth::id()) {
            Record::create([
                'user_id' => $userId,
                'action' => 'Updated Department',
                'description' => 'Department ' . $department->name . ' was updated.',
                'ip_address' => request()->ip(),
            ]);
        }
    }

    /**
     * Handle the Department "deleted" event.
     */
    public function deleted(Department $department): void
    {
        //
    }

    /**
     * Handle the Department "restored" event.
     */
    public function restored(Department $department): void
    {
        //
    }

    /**
     * Handle the Department "force deleted" event.
     */
    public function forceDeleted(Department $department): void
    {
        //
    }
}
