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
            $table->string('id',12)->primary();
            $table->string('name', 255);
            $table->string('middlename', 255)->nullable();
            $table->string('surname', 255);
            $table->string('img_path', 1024)->nullable();
            $table->string('position', 255)->nullable();
            $table->string('email')->unique();
            $table->integer('year')->nullable();
            $table->char('grade')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
