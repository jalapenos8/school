<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subject_user', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->foreignIdFor(Subject::class)->onDelete('cascade');
            $table->timestamps();
        });

        DB::unprepared('ALTER TABLE `subject_user` ADD PRIMARY KEY (  `user_id` ,  `subject_id` )');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_user');
    }
};
