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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            
            // Link to the Laboratories table
            $table->foreignId('laboratory_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable(); // Store the file path, not the image itself
            $table->string('size')->nullable(); // e.g., "500ml", "Large"
            
            // Inventory management
            $table->integer('quantity')->default(0); // Total owned
            $table->integer('available')->default(0); // Currently on shelf
            
            // Status and Safety
            $table->string('status')->default('status_unknown');
            $table->string('hazard_code')->nullable(); // e.g., "Biohazard", "Flammable"
            $table->string('location')->nullable(); // e.g., "Shelf A3", "Cabinet B1"
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
