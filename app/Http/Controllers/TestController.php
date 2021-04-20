<?php

namespace App\Http\Controllers;

use App\Models\Alleop;
use App\Models\Creature;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {

        $ss = Alleop::with('hero', 'monster')->find(1);
        $k=5;
        $l = 'monster';
        $kpr = 12;
//        $ss = null ?? $k+1;
        dd($ss->($l));
    }
}
