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
                'chance' => 10,
                'description' => 'Strike twice while it’s his turn to attack; there’s a 10% chance
he’ll use this skill every time he attacks'
            ],
            [
                'name' => 'Magic shield',
                'chance' => 20,
                'description' => 'Takes only half of the usual damage when an enemy attacks;
there’s a 20% change he’ll use this skill every time he defends.'
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
