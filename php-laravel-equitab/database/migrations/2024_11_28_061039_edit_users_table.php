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
        Schema::table('users', function(Blueprint $table) {
            $table->dropIndex('users_email_unique');
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');

            $table->renameColumn('name', 'username');

            $table->string('phone_number', 15)->unique();
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->string('picture_path')->nullable();

            $table->unique('username');
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
