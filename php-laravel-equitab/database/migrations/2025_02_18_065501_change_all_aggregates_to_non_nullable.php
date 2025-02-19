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
            $table->dropColumn('aggregate');
            $table->decimal('aggregate', 12, 4)->default(0);
        });

        Schema::table('transaction_ower', function (Blueprint $table) {
            $table->dropColumn('aggregate');
            $table->dropColumn('deleted_at');

            $table->decimal('aggregate', 12, 4)->default(0);
        });

        Schema::table('product_ower', function (Blueprint $table) {
            $table->decimal('aggregate', 12, 4)->default(0);
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
