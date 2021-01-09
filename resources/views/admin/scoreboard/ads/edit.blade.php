@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Ad
    </div>

    <div class="card-body">
        <form action="{{ route("admin.ads.update", [$ad->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('ad_title') ? 'has-error' : '' }}">
                <label for="ad_title">Ad Title*</label>
                <input type="text" id="ad_title" name="ad_title" class="form-control"
                    value="{{ old('ad_title', isset($ad) ? $ad->ad_title : '') }}" required>
                @if($errors->has('ad_title'))
                <em class="invalid-feedback">
                    {{ $errors->first('ad_title') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- helper words --}}
                </p>
            </div>

            <div class="form-group {{ $errors->has('ad_path') ? 'has-error' : '' }}">
                <label for="ad_path">Ad Path*</label>
                {{-- <input type="file" id="team_logo" name="team_logo" class="form-control"
                    value="{{ old('team_logo', isset($team) ? $team->team_logo : '') }}" required> --}}
                <input type="file" id="ad_path" name="ad_path" class="form-control" value="/storage/images/ad/{{ $ad->path }}">
                @if($errors->has('ad_path'))
                <em class="invalid-feedback">
                    {{ $errors->first('ad_path') }}
                </em>
                @endif
                <div>
                    <img height="150px" src="/storage/images/ad/{{ $ad->path }}" alt="">
                </div>
                <p class="helper-block">
                    {{-- helper words --}}
                </p>
            </div>


            <div class="form-group row">
                <label for="dropdown" class="col-sm-4 col-form-label text-md-right">Select Game</label>

                <div class="col-md-5">
                    <select class="form-control{{ $errors->has('game_id') ? ' has-error' : '' }}" name="game_id">
                        @foreach($games as $game)
                        <option {{ $game->id==$ad->game_id ? 'selected' : '' }} value="{{ $game->id }}">
                            {{ $game->game_name }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('game_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('game_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>


            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>

            {{-- <img src="" alt=""> --}}
        </form>


    </div>
</div>
@endsection