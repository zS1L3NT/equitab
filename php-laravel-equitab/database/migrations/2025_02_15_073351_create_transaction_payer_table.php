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
        Schema::create('transaction_payer', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Transaction::class)->unique()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class, 'payer_id')->constrained()->cascadeOnDelete();
            $table->decimal('aggregate', 12, 4)->nullable();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_payer');
    }
};
