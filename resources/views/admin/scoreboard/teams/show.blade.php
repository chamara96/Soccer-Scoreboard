@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Show Team
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
                            {{ $team->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Team Name
                        </th>
                        <td>
                            {{ $team->team_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Team Logo
                        </th>
                        <td>
                            {{-- {{ $team->logo }} --}}
                            <img src="/storage/images/team_logo/{{ $team->logo }}" height="150px" alt="">
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