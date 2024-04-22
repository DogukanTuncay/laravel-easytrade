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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->unsignedTinyInteger('avatar_url')->nullable()->default("0");
            $table->string('password');
            $table->string('user_type')->default("0");
            $table->decimal('token', 10, 2)->default(0.00);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
