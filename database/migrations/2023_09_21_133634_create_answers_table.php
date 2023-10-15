<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->string('QuizCode', 255);
            $table->integer('QuestionNo');
            $table->string('Answer', 255);
            $table->string('PrimaryKey', 255)->id();
            $table->integer('Pass');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
