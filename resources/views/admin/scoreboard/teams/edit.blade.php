@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Teams
    </div>

    <div class="card-body">
        <form action="{{ route("admin.teams.update", [$team->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('team_name') ? 'has-error' : '' }}">
                <label for="team_name">Team Name*</label>
                <input type="text" id="team_name" name="team_name" class="form-control"
                    value="{{ old('team_name', isset($team) ? $team->team_name : '') }}" required>
                @if($errors->has('team_name'))
                <em class="invalid-feedback">
                    {{ $errors->first('team_name') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- helper words --}}
                </p>
            </div>

            <div class="form-group {{ $errors->has('team_logo') ? 'has-error' : '' }}">
                <label for="team_logo">Team Logo*</label>
                {{-- <input type="file" id="team_logo" name="team_logo" class="form-control"
                    value="{{ old('team_logo', isset($team) ? $team->team_logo : '') }}" required> --}}
                <input type="file" id="team_logo" name="team_logo" class="form-control" value="/storage/images/team_logo/{{ $team->logo }}">
                @if($errors->has('team_logo'))
                <em class="invalid-feedback">
                    {{ $errors->first('team_logo') }}
                </em>
                @endif
                <div>
                    <img height="150px" src="/storage/images/team_logo/{{ $team->logo }}" alt="">
                </div>
                <p class="helper-block">
                    {{-- helper words --}}
                </p>
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>

            {{-- <img src="" alt=""> --}}
        </form>


    </div>
</div>
@endsection