<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobps', function (Blueprint $table) {
                 $table->id();
        $table->string('title');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
        $table->text('description');
        $table->string('location')->nullable();
        $table->date('deadline');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobps');
    }
};
