<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creature extends Model
{
    public $fillable = ['name', 'type', 'health', 'strength', 'speed', 'luck'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'creature_skills');
    }
}
