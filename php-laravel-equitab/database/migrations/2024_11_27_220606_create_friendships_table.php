<?php

use App\Enums\FriendshipStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, "from_user_id")->constrained();
            $table->foreignIdFor(\App\Models\User::class, "to_user_id")->constrained();
            $table->enum("status", [
                FriendshipStatus::Pending->value,
                FriendshipStatus::Accepted->value,
                FriendshipStatus::Rejected->value,
                FriendshipStatus::Blocked->value
            ])->default(FriendshipStatus::Pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
