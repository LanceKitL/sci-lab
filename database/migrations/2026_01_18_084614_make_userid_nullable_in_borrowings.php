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
        Schema::table('borrowings', function (Blueprint $table) {
            // 1. Make user_id nullable (because walk-ins don't have a user account)
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // 2. Add attendance_id to link to the manual log
            $table->foreignId('attendance_id')->nullable()->constrained()->onDelete('cascade')->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->dropForeign(['attendance_id']);
            $table->dropColumn('attendance_id');
        });
    }
};
