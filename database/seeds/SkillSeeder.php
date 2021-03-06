<?php

use App\Models\Creature;
use App\Models\CreatureSkill;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Rapid strike',
                'chance' => 20,
                'icon' => '<i class="fas fa-long-arrow-alt-right"></i>',
                'description' => 'Strike twice while it’s his turn to attack; there’s a 20% chance
he’ll use this skill every time he attacks',
                'attack_coefficient' => 2,
            ],
            [
                'name' => 'Magic shield',
                'chance' => 30,
                'icon' => '<i class="fas fa-shield-alt"></i>',
                'description' => 'Takes only half of the usual damage when an enemy attacks;
there’s a 30% change he’ll use this skill every time he defends.',
                'damage_coefficient' => 0.5,
            ],
        ];

        foreach ($data as $skill){
            $skill = Skill::create($skill);
            CreatureSkill::create([
                'creature_id' => Creature::where('name', 'Vaderus')->first()->id,
                'skill_id' => $skill->id,
            ]);
        }
    }
}
