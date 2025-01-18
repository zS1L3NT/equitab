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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Ledger::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('location')->nullable();
            $table->dateTime('datetime');
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained();
            $table->foreignIdFor(\App\Models\User::class, 'payer_id')->constrained()->cascadeOnDelete();
            $table->decimal('cost', 12, 4);
            $table->string('currency', 3);
            $table->decimal('rate', 10, 6)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
