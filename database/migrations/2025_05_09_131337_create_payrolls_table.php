<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('pay_period_start')->default(now());;
            $table->date('pay_period_end')->default(now());;
            $table->decimal('total_earnings', 10, 2)->default(0)->change();
            $table->decimal('total_deductions', 10, 2)->default(0)->change();
            $table->decimal('net_pay', 10, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
