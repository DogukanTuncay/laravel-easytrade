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
            $table->unsignedTinyInteger('avatar_id')->nullable()->default("0");
            $table->string('password');
            $table->string('user_type')->default("0");
            $table->string('company_name')->nullable(); // firma adı alanı, boş geçilebilir olarak ayarlandı
            $table->integer('company_worker_count')->nullable(); // Firma Çalışan Sayısı, boş  geçilebilir olarak ayarlı.
            $table->decimal('token', 10, 2)->default(0.00);
            $table->string('mail_api_key')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->boolean('mail_activate')->default(false);
            $table->boolean('wp_activate')->default(false);
            $table->boolean('isAdmin')->default('0');
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
