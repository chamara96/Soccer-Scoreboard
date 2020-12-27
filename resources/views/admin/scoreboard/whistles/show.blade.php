@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Show Whistle
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            Id
                        </th>
                        <td>
                            {{ $whistle->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Whistle Name
                        </th>
                        <td>
                            {{ $whistle->whistle_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Sound Clip
                        </th>
                        <td>
                            <audio controls>
                                <source src="/storage/sounds/whistle_clips/{{ $whistle->soundclip }}" type="audio/mpeg"> 
                            </audio>
                            {{-- {{ $whistle->soundclip }} --}}
                            {{-- <img src="/storage/images/team_logo/{{ $team->logo }}" height="150px" alt=""> --}}
                        </td>
                    </tr>

                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>

        <nav class="mb-3">
            <div class="nav nav-tabs">

            </div>
        </nav>
        <div class="tab-content">

        </div>
    </div>
</div>
@endsection