@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Show Timer
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
                            {{ $timer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Timer Name
                        </th>
                        <td>
                            {{ $timer->timer_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Timer Duration
                        </th>
                        <td>
                            {{ $timer->time }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Start Whistle
                        </th>
                        <td>
                            {{ $start_whistles->whistle_name }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            End Whistle
                        </th>
                        <td>
                            {{ $end_whistles->whistle_name }}
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