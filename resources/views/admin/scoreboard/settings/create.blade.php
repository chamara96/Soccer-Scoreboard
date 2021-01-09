@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Scoreboard Settings
    </div>

    <div class="card-body">
        <form action="{{ route("admin.settings.store") }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="">{{$settings->name}}</label>
                <img height="200px" src="/storage/images/backgrounds/{{$settings->value}}" alt="">
            </div>

            <div class="form-group {{ $errors->has('bg_path') ? 'has-error' : '' }}">
                <label for="bg_path">Background*</label>
                <input type="file" id="bg_path" name="bg_path" class="form-control"
                    value="" required>
                @if($errors->has('bg_path'))
                <em class="invalid-feedback">
                    {{ $errors->first('bg_path') }}
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