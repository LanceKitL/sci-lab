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
            // We make it nullable first so it doesn't break existing data, 
            // but for new data it will be required logic-wise.
            $table->string('transaction_id')->unique()->after('id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
};
