<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;
    
    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Unit::class);
    }

    public function steps()
    {
        return $this->hasManyThrough(Step::class, Lesson::class);
    }
    
    protected $fillable = [
        'name',
        'grade',
        'img',
    ];
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
