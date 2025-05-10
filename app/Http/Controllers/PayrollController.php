<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Salary;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Store a newly created payroll in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after_or_equal:pay_period_start',
            'payment_date' => 'required|date',
        ]);

        // Retrieve salary records for the specified employee and pay period
        $salaries = Salary::where('employee_id', $request->employee_id)
            ->whereBetween('salary_date', [$request->pay_period_start, $request->pay_period_end])
            ->get();

        // Calculate total earnings and deductions
        $totalEarnings = $salaries->sum('basic_salary') + $salaries->sum('allowances');
        $totalDeductions = $salaries->sum('deductions');
        $netPay = $totalEarnings - $totalDeductions;
        
        Payroll::create([
            'employee_id' => $request->employee_id,
            'pay_period_start' => $request->pay_period_start,
            'pay_period_end' => $request->pay_period_end,
            'total_earnings' => $totalEarnings,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay,
            'payment_date' => $request->payment_date,
            'status' => 'pending',
        ]);

        // Redirect to the payroll index with a success message
        return redirect()->route('payrolls.index')->with('success', 'Payroll created successfully.');
    }
}
