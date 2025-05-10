<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'department_id',
        'date',
        'time_in',
        'time_out',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function booted()
{
static::saving(function ($attendance) {
    if ($attendance->time_in) {
        $officialStart = '11:00:00';
        $officialEnd = '13:00:00';

        $timeIn = date('H:i:s', strtotime($attendance->time_in));

        if ($timeIn > $officialStart) {
            $attendance->status = 'late';
        } else {
            $attendance->status = 'on time';
        }
    }

        // If time_out is being set, ensure it's after time_in
      if ($attendance->time_out) {
    $timeOut = date('H:i:s', strtotime($attendance->time_out));

    if ($timeOut < $officialEnd) {
        $attendance->status = 'absent';
    }
}

        // If the status is 'late', apply the deduction logic
        if ($attendance->status === 'late') {
            $employee = $attendance->employee;
            if ($employee) {
                // Assuming each employee has one salary record
                $salary = $employee->salary;

                if ($salary) {
                    // Prevent double deduction: Only apply deduction if it hasn't been applied yet
                    if (!$attendance->deduction_applied) { // Add a check for this flag
                        // Calculate deduction as 10% of the basic salary (or modify as needed)
                        $deductionAmount = $salary->basic_salary * 0.10; // 10% deduction

                        // Add this deduction to the employee's existing deductions
                        $salary->deductions += $deductionAmount;

                        // Recalculate net salary
                        $salary->net_salary = $salary->basic_salary + $salary->allowances - $salary->deductions;

                        // Save the updated salary record
                        $salary->save();

                        // Mark that the deduction has been applied to avoid double deduction
                        $attendance->deduction_applied = true;
                    }
                }
            }
        }
    });
}

}
