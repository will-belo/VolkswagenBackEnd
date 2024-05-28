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
        Schema::create('trainings_format', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained(
                table: 'trainings'
            );
            $table->foreignId('common_user_id')->constrained(
                table: 'common_user'
            );
            $table->foreignId('concessionaire_id')->nullable()->constrained(
                table: 'concessionaire'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
