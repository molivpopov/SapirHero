<?php

use App\Models\Creature;
use Illuminate\Database\Seeder;

class CreatureSeeder extends Seeder
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
                'name' => 'Vaderus',
                'type' => 'hero',
                'health' => '70-100',
                'strength' => '70-80',
                'speed' => '40-50',
                'defence' => '45-55',
                'luck' => '10-30'
            ],
            [
                'name' => 'wild beast',
                'type' => 'monster',
                'health' => '60-90',
                'strength' => '60-90',
                'defence' => '40-60',
                'speed' => '40-60',
                'luck' => '10-30'
            ],
        ];

        foreach ($data as $creature){
            Creature::create($creature);
        }
    }
}
