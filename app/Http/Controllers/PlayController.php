<?php

namespace App\Http\Controllers;

use App\Models\Alleop;
use App\Models\Creature;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function index()
    {
        $alleop = Alleop::with('hero.skills', 'monster')->where('status', 'play')->get();

        $game = $alleop->isNotEmpty() ? $alleop[0]->game : 0;

        return view('play', compact('alleop', 'game'));
    }

    public function newGame($hero = 'Vaderus', $monster = 'wild beast')
    {
        Alleop::where('status', 'play')->update(['status' => 'finished']);

        $lastGame = Alleop::max('game') ?? 0;

        $hero = Creature::with('skills')->where('name', $hero)->first();

        $monster = Creature::where('name', $monster)->first();

        Alleop::create([
            'game' => $lastGame + 1,
            'turn' => 1,
            'hero_id' => $hero->id,
            'monster_id' => $monster->id,
            'health_hero' => $hero->health->value,
            'health_monster' => $monster->health->value,
            'status' => 'play',
            'used_skills' => $hero->skills,
        ]);

        return redirect()->route('play');
    }
}
