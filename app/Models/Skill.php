<?php

namespace App\Models;

use App\Casts\SkillChance;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $casts = ['chance' => SkillChance::class];
}
