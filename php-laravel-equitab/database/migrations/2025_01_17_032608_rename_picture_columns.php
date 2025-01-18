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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('picture_path', 'picture');
        });

        Schema::table('ledgers', function (Blueprint $table) {
            $table->renameColumn('picture_path', 'picture');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('picture_path', 'picture');
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
