<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    
    public function nextStep(Step $step)
    {
        return $this->steps()->where('id','>',$step->id)->first();
    }

    protected $fillable = [
        'name',
        'description',
        'type',
    ];
}
