<?php

namespace App\Http\Controllers;

use App\Models\Alleop;
use App\Traits\Engine;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    use Engine;

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

        $ret = $this->nextTurn(Alleop::max('game') + 1, 1);

        return redirect()->route('play');
    }

    public function turn()
    {

    }
}
