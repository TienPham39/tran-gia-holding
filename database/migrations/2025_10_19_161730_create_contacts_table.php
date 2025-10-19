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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();        // Họ và tên
            $table->string('phone', 20)->nullable();        // Số điện thoại
            $table->string('email', 150)->nullable();       // Email
            $table->text('message')->nullable();            // Lời nhắn
            $table->string('ip_address', 45)->nullable();   // IP của người gửi (IPv4/IPv6)
            $table->string('status', 20)->default('new');   // new | read | replied
            $table->timestamps();                           // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
