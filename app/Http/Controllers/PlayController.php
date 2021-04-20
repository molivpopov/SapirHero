<?php

namespace App\Http\Controllers;

use App\Models\Alleop;
use App\Models\Creature;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function index()
    {
        $alleop = Alleop::with('hero.skills', 'monster')
            ->whereIn('status', ['playing', 'finished'])
            ->get();

        $game = $alleop->isNotEmpty() ? $alleop[0]->game : 0;

        return view('play', compact('alleop', 'game'));
    }

    public function newGame()
    {
        Alleop::whereIn('status', ['playing', 'finished'])
            ->update(['status' => 'archived']);

        $this->nextTurn(Alleop::max('game') + 1, 1);

        return redirect()->route('play');
    }

    public function turn()
    {

    }

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
            //'health_hero' => $hero->health->value,
            //'health_monster' => $monster->health->value,
            'status' => 'playing',
            'used_skills' => $hero->skills,
        ])->id;

        $alleop = Alleop::find($alleope_id);

        $heroSkills = $alleop->used_skills;

        $damCoeff = $heroSkills
            ->reduce(function ($carry, $item) {
                return $carry * $item->damage_coefficient;
            });

        $attackCoeff = $heroSkills
            ->reduce(function ($carry, $item) {
                return $carry * $item->attack_coefficient;
            });

        $heroProperties = $this->getProperties($hero);
        $monsterProperties = $this->getProperties($monster);

        $attacker = $heroProperties->speed == $monsterProperties->speed
            ? ($heroProperties->luck > $monsterProperties->luck ? 'hero' : 'monster')
            : ($heroProperties->speed > $monsterProperties->speed ? 'hero': 'monster');

        $defender = $attacker == 'hero' ? 'monster' : 'hero';

        $heroDamage = ($monsterProperties->strength - $heroProperties->defence) * $damCoeff;
        $heroDamage *= (int)(rand(0,100) > $heroProperties->luck);
        $heroHealth = $heroProperties->health - $heroDamage;

        $monsterDamage = $heroProperties->strength * $attackCoeff - $monsterProperties->defence;
        $monsterDamage *= (int)(rand(0,100) > $monsterProperties->luck);
        $monsterHealth = $monsterProperties->health - $monsterDamage;

//        if($monsterHealth > 0 && $heroHealth > 0){
//            $alleop->health_hero = $heroHealth;
//            $alleop->health_monster = $monsterHealth;
//        } elseif ()


    }

    private function getProperties($creature)
    {
        $properties = config('properties');

        return (object)array_map(
            function ($v, $k) use ($creature) {
                return $creature->$k->value;
            }, array_fill_keys($properties, false)
        );
    }
}
