<?php

namespace App\Models;

use App\Casts\RangeCast;
use Illuminate\Database\Eloquent\Model;

class Creature extends Model
{

    public $fillable = ['name', 'type', 'health', 'strength', 'speed', 'luck', 'defence'];

    protected $casts = [
        'health' => RangeCast::class,
        'strength' => RangeCast::class,
        'speed' => RangeCast::class,
        'luck' => RangeCast::class,
        'defence' => RangeCast::class,
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'creature_skills');
    }
}
