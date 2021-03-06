@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Teams
    </div>

    <div class="card-body">
        <form action="{{ route("admin.timers.update", [$timer->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('timer_name') ? 'has-error' : '' }}">
                <label for="timer_name">Timer Name*</label>
                <input type="text" id="timer_name" name="timer_name" class="form-control"
                    value="{{ old('timer_name', isset($timer) ? $timer->timer_name : '') }}" required>
                @if($errors->has('timer_name'))
                <em class="invalid-feedback">
                    {{ $errors->first('timer_name') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>

            <div class="form-group {{ $errors->has('time') ? 'has-error' : '' }}">
                <label for="time">Time Duration*</label>
                <input type="text" id="time" name="time" class="form-control"
                    value="{{ old('time', isset($timer) ? $timer->time : '') }}" required>
                @if($errors->has('time'))
                <em class="invalid-feedback">
                    {{ $errors->first('time') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>

            <div class="form-group">
                <label for="dropdown">Start Whistle</label>
                <div class="form-control{{ $errors->has('start_whistle_id') ? ' has-error' : '' }}">
                    @foreach ($whistles as $whistle)
                    <input required type="radio" name="start_whistle_id" value="{{ $whistle->id }}"
                        {{ ($whistle->id==$timer->start_whistle_id)? "checked" : "" }}>{{ $whistle->whistle_name }}</label>
                    @endforeach
                </div>

                @if ($errors->has('start_whistle_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('start_whistle_id') }}</strong>
                </span>
                @endif

            </div>

            <div class="form-group">
                <label for="dropdown">End Whistle</label>
                <div class="form-control{{ $errors->has('end_whistle_id') ? ' has-error' : '' }}">
                    @foreach ($whistles as $whistle)
                    <input required type="radio" name="end_whistle_id" value="{{ $whistle->id }}"
                        {{ ($whistle->id==$timer->end_whistle_id)? "checked" : "" }}>{{ $whistle->whistle_name }}</label>
                    @endforeach
                </div>


                @if ($errors->has('end_whistle_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('end_whistle_id') }}</strong>
                </span>
                @endif

            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>

            {{-- <img src="" alt=""> --}}
        </form>


    </div>
</div>
@endsection