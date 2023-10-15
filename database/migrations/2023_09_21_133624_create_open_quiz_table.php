<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Quiz;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('openQuiz', function (Blueprint $table) {
            $table->string('QuizCode', 255)->id();
            $table->foreignIdFor(Quiz::class)->onDelete('cascade');
            $table->foreignIdFor(User::class)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openQuiz');
    }
};
