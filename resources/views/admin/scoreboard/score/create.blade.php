@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Game
    </div>

    <div class="card-body">
        <form action="{{ route("admin.games.store") }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group {{ $errors->has('game_name') ? 'has-error' : '' }}">
                <label for="game_name">Game Name*</label>
                <input type="text" id="game_name" name="game_name" class="form-control"
                    value="{{ old('game_name', isset($games) ? $games->game_name : '') }}" required>
                @if($errors->has('game_name'))
                <em class="invalid-feedback">
                    {{ $errors->first('game_name') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>

            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                <label for="date">Game Date*</label>
                <input type="text" id="date" name="date" class="form-control"
                    value="{{ old('date', isset($games) ? $games->date : '') }}" required>
                @if($errors->has('date'))
                <em class="invalid-feedback">
                    {{ $errors->first('date') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>

            <div class="form-group {{ $errors->has('ground') ? 'has-error' : '' }}">
                <label for="ground">Ground*</label>
                <input type="text" id="ground" name="ground" class="form-control"
                    value="{{ old('ground', isset($games) ? $games->ground : '') }}" required>
                @if($errors->has('ground'))
                <em class="invalid-feedback">
                    {{ $errors->first('ground') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>

            <div class="form-group {{ $errors->has('game_logo_raw') ? 'has-error' : '' }}">
                <label for="game_logo_raw">Game Logo*</label>
                <input type="file" id="game_logo_raw" name="game_logo_raw" class="form-control" required>
                @if($errors->has('game_logo_raw'))
                <em class="invalid-feedback">
                    {{ $errors->first('game_logo_raw') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>

            <div class="form-group row">
                <label for="dropdown" class="col-sm-4 col-form-label text-md-right">Team A</label>

                <div class="col-md-5">
                    <select class="form-control{{ $errors->has('team_a') ? ' has-error' : '' }}" name="team_a">
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('team_a'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('team_a') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="dropdown" class="col-sm-4 col-form-label text-md-right">Team B</label>

                <div class="col-md-5">
                    <select class="form-control{{ $errors->has('team_b') ? ' has-error' : '' }}" name="team_b">
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('team_b'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('team_b') }}</strong>
                    </span>
                    @endif
                </div>
            </div>


            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection