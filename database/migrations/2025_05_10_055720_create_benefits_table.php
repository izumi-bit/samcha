<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('benefits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();
        });

        // Seed initial benefits
        DB::table('benefits')->insert([
            ['name' => 'SSS', 'amount' => 500, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pag-IBIG', 'amount' => 200, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PhilHealth', 'amount' => 300, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('benefits');
    }
};