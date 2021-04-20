<?php


namespace App\Traits;


use App\Models\Alleop;
use App\Models\Creature;

trait Engine
{
    private function nextTurn($game, $turn = null, $hero = 'Vaderus', $monster = 'wild beast')
    {
        $turn = $turn ?? Alleop::where('game', $game)->max('turn') + 1;

        $hero = Creature::with('skills')->where('name', $hero)->first();

        $monster = Creature::where('name', $monster)->first();

        $alleope_id = Alleop::create([
            'game' => $game,
            'turn' => $turn,
            'hero_id' => $hero->id,
            'monster_id' => $monster->id,
            'status' => 'playing',
            'used_skills' => $hero->skills,
        ])->id;

        $alleop = Alleop::find($alleope_id);

        $heroSkills = $alleop->used_skills;

        $damCoeff = $heroSkills
            ->reduce(function ($carry, $item) {
                return $carry * $item->damage_coefficient;
            }, 1);

        $attackCoeff = $heroSkills
            ->reduce(function ($carry, $item) {
                return $carry * $item->attack_coefficient;
            }, 1);

        $heroProperties = $this->getProperties($hero);
        $monsterProperties = $this->getProperties($monster);

        $attacker = $heroProperties->speed == $monsterProperties->speed
            ? ($heroProperties->luck > $monsterProperties->luck ? 'hero' : 'monster')
            : ($heroProperties->speed > $monsterProperties->speed ? 'hero' : 'monster');

        $defender = $attacker == 'hero' ? 'monster' : 'hero';

        $heroDamage = ($monsterProperties->strength - $heroProperties->defence) * ($damCoeff??1);
        $heroDamage *= (int)(rand(0, 100) > $heroProperties->luck);
        $heroHealth = $heroProperties->health - $heroDamage;

        $monsterDamage = $heroProperties->strength * ($attackCoeff??1) - $monsterProperties->defence;
        $monsterDamage *= (int)(rand(0, 100) > $monsterProperties->luck);
        $monsterHealth = $monsterProperties->health - $monsterDamage;

        $hd = $defender . 'Health';
        $ha = $attacker . 'Health';
        $pd = 'health_' . $attacker;
        $ap = $attacker . 'Properties';
        $dp = $defender . 'Properties';
        $pa = 'health_' . $defender;

        if ($monsterHealth > 0 && $heroHealth > 0) {
            $alleop->health_hero = $heroHealth;
            $alleop->health_monster = $monsterHealth;
        } elseif ($$hd <= 0) {
            $alleop->$pd = $$ap->health;
            $alleop->status = 'finished';
        } elseif ($$ha <= 0) {
            $alleop->$pa = $$hd;
            $alleop->status = 'finished';
        };

        $alleop->damage_hero = $heroDamage;
        $alleop->damage_monster = $monsterDamage;

        $alleop->save();

        return (object)[$attacker => $$ap, $defender => $$dp];
    }

    private function getProperties($creature)
    {
        $res = [];

        foreach (config('properties') as $key => $property) {
            $res[$property] = $creature->$property->value;
        }

        return (object)$res;
    }
}
