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

        $game = $alleop->last();

        $startProperties = session('startProperties');

        //dd($startProperties);

        return view('play', compact('alleop', 'game', 'startProperties'));
    }

    public function newGame()
    {
        Alleop::whereIn('status', ['playing', 'finished'])
            ->update(['status' => 'archived']);

        $ret = $this->nextTurn(Alleop::max('game') + 1, 1);

        session(['startProperties' => $ret]);

        return redirect()->route('play');
    }

    public function turn()
    {
        $ret = $this->nextTurn(Alleop::max('game'));

        session(['startProperties' => $ret]);

        return redirect()->route('play');
    }
}
