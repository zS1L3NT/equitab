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
        Schema::create('ledger_user', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Ledger::class)->constrained();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['ledger_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_user');
    }
};
