@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Songs
    </div>

    <div class="card-body">
        <form action="{{ route("admin.songs.update", [$song->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('song_name') ? 'has-error' : '' }}">
                <label for="song_name">Song Name*</label>
                <input type="text" id="song_name" name="song_name" class="form-control"
                    value="{{ old('song_name', isset($song) ? $song->song_name : '') }}" required>
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
                <br>
                <audio controls>
                    <source src="/storage/sounds/song_clips/{{ $song->songclip }}" type="audio/mpeg"> 
                </audio>
                {{-- <input type="file" id="songclip_raw" name="songclip_raw" class="form-control"
                    value="{{ old('soundclip', isset($whistles) ? $whistle->soundclip : '') }}" required> --}}
                <input type="file" id="songclip_raw" name="songclip_raw" class="form-control" value="/storage/sounds/song_clips/{{ $song->songclip }}">
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