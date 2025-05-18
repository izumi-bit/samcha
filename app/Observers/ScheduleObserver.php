<?php

namespace App\Observers;

use App\Models\schedule;

class ScheduleObserver
{
    /**
     * Handle the schedule "created" event.
     */
    public function created(schedule $schedule): void
    {
        //
    }

    /**
     * Handle the schedule "updated" event.
     */
    public function updated(schedule $schedule): void
    {
        //
    }

    /**
     * Handle the schedule "deleted" event.
     */
    public function deleted(schedule $schedule): void
    {
        //
    }

    /**
     * Handle the schedule "restored" event.
     */
    public function restored(schedule $schedule): void
    {
        //
    }

    /**
     * Handle the schedule "force deleted" event.
     */
    public function forceDeleted(schedule $schedule): void
    {
        //
    }
}
