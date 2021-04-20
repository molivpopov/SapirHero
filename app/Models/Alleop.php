<?php

namespace App\Models;

use App\Casts\UsedSkills;
use Illuminate\Database\Eloquent\Model;

class Alleop extends Model
{
    public $table = 'alleop';

    public $fillable = [
        'game',
        'turn',
        'hero_id',
        'monster_id',
        'health_hero',
        'health_monster',
        'status',
        'used_skills',
        'damage_hero',
        'damage_monster',
    ];

    protected $casts = ['used_skills' => UsedSkills::class];

    public function hero()
    {
        return $this->hasOne(Creature::class, 'id', 'hero_id');
    }

    public function monster()
    {
        return $this->hasOne(Creature::class, 'id', 'monster_id');
    }
}
