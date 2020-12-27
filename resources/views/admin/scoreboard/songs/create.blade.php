@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Add Song
    </div>

    <div class="card-body">
        <form action="{{ route("admin.songs.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('song_name') ? 'has-error' : '' }}">
                <label for="song_name">Song Title*</label>
                <input type="text" id="song_name" name="song_name" class="form-control"
                    value="{{ old('song_name', isset($songs) ? $songs->song_name : '') }}" required>
                @if($errors->has('song_name'))
                <em class="invalid-feedback">
                    {{ $errors->first('song_name') }}
                </em>
                @endif
                <p class="helper-block">
                    {{-- add help word --}}
                </p>
            </div>
            <div class="form-group {{ $errors->has('songclip_raw') ? 'has-error' : '' }}">
                <label for="songclip_raw">Song Clip*</label>
                <input type="file" id="songclip_raw" name="songclip_raw" class="form-control"
                    value="{{ old('songclip_raw', isset($songs) ? $songs->songclip_raw : '') }}" required>
                @if($errors->has('songclip_raw'))
                <em class="invalid-feedback">
                    {{ $errors->first('songclip_raw') }}
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