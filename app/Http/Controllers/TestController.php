<?php

namespace App\Http\Controllers;

use App\Models\Creature;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $ss = Creature::with('skills')->where('name', 'Vaderus')->first();
        dd($ss);
    }
}
