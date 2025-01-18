<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_ower', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Transaction::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class, 'ower_id')->constrained()->cascadeOnDelete();

            $table->unique(['transaction_id', 'ower_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_ower');
    }
};
