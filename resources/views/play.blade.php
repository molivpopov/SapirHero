@extends('layouts.app')

@php($active = 'Gameplay')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if(isset($alleop) && $alleop->isNotEmpty())
                            <span class="mr-2">game# {{$game}}</span> <a href="#">turn</a>
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
                                    <th class="text-center">attack</th>
                                    <th style="width: 7%"></th>
                                    <th class="text-right">monster</th>
                                    <th style="width: 4%"><i class="fas fa-heart text-info"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($alleop as $turn)
                                    <tr>
                                        <td>{{$turn->turn}}</td>
                                        <td>{{$turn->health_hero}}</td>
                                        <td>{{$turn->hero->name}}</td>
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
                                        <td class="text-center"><progress value="25" max="100" style="transform: rotate(180deg);"></progress></td>
                                        <td></td>
                                        <td class="text-right">{{$turn->monster->name}}</td>
                                        <td>{{$turn->health_monster}}</td>
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
