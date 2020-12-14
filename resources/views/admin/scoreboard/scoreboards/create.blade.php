@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Timer
    </div>

    <div class="card-body">
        <form action="{{ route("admin.timers.store") }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group {{ $errors->has('timer_name') ? 'has-error' : '' }}">
                <label for="timer_name">Timer Name*</label>
                <input type="text" id="timer_name" name="timer_name" class="form-control"
                    value="{{ old('timer_name', isset($timers) ? $timers->timer_name : '') }}" required>
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
                    value="{{ old('time', isset($timers) ? $timers->time : '') }}" required>
                @if($errors->has('time'))
                <em class="invalid-feedback">
                    {{ $errors->first('time') }}
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