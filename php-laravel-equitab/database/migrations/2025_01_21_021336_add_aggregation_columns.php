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
        Schema::table('ledger_user', function (Blueprint $table) {
            $table->dropColumn('created_at');

            $table->decimal('aggregate', 12, 4)->nullable();
        });

        Schema::table('transaction_ower', function (Blueprint $table) {
            $table->decimal('aggregate', 12, 4)->nullable();
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
