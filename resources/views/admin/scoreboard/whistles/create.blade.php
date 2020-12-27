@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Whistle
    </div>

    <div class="card-body">
        <form action="{{ route("admin.whistles.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('whistle_name') ? 'has-error' : '' }}">
                <label for="whistle_name">Whistle Name*</label>
                <input type="text" id="whistle_name" name="whistle_name" class="form-control"
                    value="{{ old('whistle_name', isset($whistles) ? $whistles->whistle_name : '') }}" required>
                @if($errors->has('whistle_name'))
                <em class="invalid-feedback">
                    {{ $errors->first('whistle_name') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>
            <div class="form-group {{ $errors->has('soundclip_raw') ? 'has-error' : '' }}">
                <label for="soundclip_raw">Whistle Scound Clip*</label>
                <input type="file" id="soundclip_raw" name="soundclip_raw" class="form-control"
                    value="{{ old('soundclip_raw', isset($whistles) ? $whistle->soundclip_raw : '') }}" required>
                @if($errors->has('soundclip_raw'))
                <em class="invalid-feedback">
                    {{ $errors->first('soundclip_raw') }}
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