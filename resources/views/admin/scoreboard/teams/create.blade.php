@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Team
    </div>

    <div class="card-body">
        <form action="{{ route("admin.teams.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('team_name') ? 'has-error' : '' }}">
                <label for="team_name">Team Name*</label>
                <input type="text" id="team_name" name="team_name" class="form-control"
                    value="{{ old('team_name', isset($teams) ? $teams->team_name : '') }}" required>
                @if($errors->has('team_name'))
                <em class="invalid-feedback">
                    {{ $errors->first('team_name') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>
            <div class="form-group {{ $errors->has('team_logo') ? 'has-error' : '' }}">
                <label for="team_logo">Team Logo*</label>
                <input type="file" id="team_logo" name="team_logo" class="form-control"
                    value="{{ old('team_logo', isset($teams) ? $teams->team_logo : '') }}" required>
                @if($errors->has('team_logo'))
                <em class="invalid-feedback">
                    {{ $errors->first('team_logo') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection