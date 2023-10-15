<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->keyType = 'string';
        });
    }
    
    protected $fillable = [
        'id',
        'QuizID',
        'QuizName',
        'QuizDescription',
        'NumOfQuest',
        'QuizJSON',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'id' => 'string',
    ];
    
    public $incrementing = false;
}
