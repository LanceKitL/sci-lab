<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
        {
            Schema::create('attendances', function (Blueprint $table) {
                // this is for students and faculty attendace for borrowing a lab
                $table->id();
                $table->string('name');         // Manual entry of name
                $table->string('section');      // e.g., "Grade 10 - Einstein" or "Faculty"
                $table->dateTime('visit_time'); // Stores both date and time
                $table->string('laboratory');  
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
