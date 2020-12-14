@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Show Game
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            Id
                        </th>
                        <td>
                            {{ $game->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Game Name
                        </th>
                        <td>
                            {{ $game->game_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Game Date
                        </th>
                        <td>
                            {{ $game->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Ground
                        </th>
                        <td>
                            {{ $game->ground }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Game Logo
                        </th>
                        <td>
                            <img src="/storage/images/game_logo/{{ $game->game_logo }}" height="150px" alt="">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Team A
                        </th>
                        <td>
                            {{ $teams->where('id', $game->team_a)->first()->team_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Team B
                        </th>
                        <td>
                            {{ $teams->where('id', $game->team_b)->first()->team_name }}
                        </td>
                    </tr>
                    

                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>

        <nav class="mb-3">
            <div class="nav nav-tabs">

            </div>
        </nav>
        <div class="tab-content">

        </div>
    </div>
</div>
@endsection