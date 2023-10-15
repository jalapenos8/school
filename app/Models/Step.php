<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Step extends Model
{
    use HasFactory;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
        ->withPivot('result')
        ->withTimestamps();
    }

    public function getResult($user)
    {
        return DB::table('step_user')
            ->where([
                'user_id' => $user,
                'step_id' => $this->id,
            ])->first()->result;
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    protected $fillable = [
        'name',
        'type',
        'content',
        'max',
    ];
}
