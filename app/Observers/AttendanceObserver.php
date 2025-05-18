<?php

namespace App\Observers;

use App\Models\Attendance;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;

class AttendanceObserver
{
    public function saved(Attendance $attendance): void
    {
        if (in_array($attendance->status, ['late', 'on time'])) {
            Record::create([
                'user_id' => Auth::id() ?? optional($attendance->employee)->user_id,
                'action' => 'Attendance Recorded',
                'description' => 'Employee ' . optional($attendance->employee)->first_name . ' was marked as "' . $attendance->status . '" on ' . $attendance->date,
                'ip_address' => request()->ip(),
            ]);
        }
    }
}
