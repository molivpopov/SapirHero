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
            ],
            [
                'name' => 'Magic shield',
                'chance' => 20,
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
