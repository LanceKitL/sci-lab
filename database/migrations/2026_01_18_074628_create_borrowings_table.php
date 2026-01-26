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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');     // Who borrowed it
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade'); // What they borrowed
            $table->integer('quantity');                                           // How many
            $table->timestamp('borrowed_at');                                      // When
            $table->timestamp('returned_at')->nullable();                          // When (if) returned
            $table->string('status')->default('active');                           // active, returned, overdue
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
