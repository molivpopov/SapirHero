@extends('layouts.app')

@php($active = 'Gameplay')

@section('styles')
    <style>
        @keyframes attack {
            0%   {
                opacity: 1;
                font-weight: normal;
            }
            25%  {
                opacity: 0.4;
                font-weight: bold;
                color: red;
            }
            50%  {
                opacity: 1;
                font-weight: normal;
            }
            75%  {
                opacity: 0.4;
                font-weight: bold;
                color: red;
            }
            100% {
                opacity: 1;
                font-weight: normal;
            }
        }

        .hidden-damage {
            display: none;
        }

        .back-progress{
            transform: rotate(180deg);
        }

        .attacker-name{
            animation-name: attack;
            animation-duration: 1.5s;
        }
    </style>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous" defer></script>
    <script src="{{asset('js/event.js')}}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        @if(isset($alleop) && $alleop->isNotEmpty() && $game->status != 'finished')
                            <span class="mr-2">game# {{$game->game}}</span> <a href="{{route('next')}}">turn</a>
                        @else
                            <a href="{{route('new')}}">new game</a>
                        @endif
                    </div>

                    <div class="card-body">
                        @if(isset($alleop) && $alleop->isNotEmpty())
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th style="width: 7%">turn</th>
                                    <th style="width: 4%"><i class="fas fa-heart text-danger"></i></th>
                                    <th style="width: 10%">hero</th>
                                    <th style="width: 7%"></th>
                                    <th style="width: 7%" class="text-right"><i class="fas fa-long-arrow-alt-right"></i></th>
                                    <th class="text-center">attack</th>
                                    <th style="width: 7%"><i class="fas fa-long-arrow-alt-left"></i></th>
                                    <th style="width: 7%"></th>
                                    <th class="text-right">monster</th>
                                    <th style="width: 4%"><i class="fas fa-heart text-info"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($alleop as $turn)
                                    <tr @if($loop->last) id="actual-turn" @endif>
                                        <td>{{$turn->turn}}</td>
                                        @if($loop->last)
                                            <td data="{{$turn->health_hero}}">{{isset($startProperties) ?$startProperties->hero->health : ''}}</td>
                                        @else
                                            <td>{{$turn->health_hero}}</td>
                                        @endif
                                        <td class="@if($loop->last && $turn->attacker_id == $turn->hero_id) attacker-name @endif">{{$turn->hero->name}}</td>
                                        <td class="text-success">
                                            @if($turn->used_skills->isNotEmpty())
                                                @foreach($turn->used_skills as $skill)
                                                    @if (!$loop->first)
                                                        &emsp;
                                                    @endif
                                                    {!! $skill->icon !!}
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-right"><span class="@if($loop->last) hidden-damage @endif">{{$turn->damage_monster}}</span></td>
                                        <td class="text-center">
                                            @if($turn->status != 'finished')
                                                <progress value="0" max="100" class="@if($turn->attacker_id == $turn->monster_id) back-progress @endif"></progress>
                                            @else
                                                <span><b>game over on {{$turn->turn}} turn</b></span>
                                            @endif
                                        </td>
                                        <td><span class="@if($loop->last) hidden-damage @endif">{{$turn->damage_hero}}</span></td>
                                        <td></td>
                                        <td class="text-right @if($loop->last && $turn->attacker_id == $turn->monster_id) attacker-name @endif">{{$turn->monster->name}}</td>
                                        @if($loop->last)
                                            <td data="{{$turn->health_monster}}">{{isset($startProperties) ? $startProperties->monster->health : ''}}</td>
                                        @else
                                            <td>{{$turn->health_monster}}</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <span>моля натиснете new game, за да започне нова игра!</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
