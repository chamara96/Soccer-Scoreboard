@extends('layouts.admin')

@section('content')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.games.create") }}">
            Add Game
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Game List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Permission">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Id
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Game Name
                        </th>
                        <th>
                            Start Date
                        </th>
                        <th>
                            Ground
                        </th>
                        <th>
                            Game Logo
                        </th>
                        <th>
                            Team A
                        </th>
                        <th>
                            Team B
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $key => $game)
                    <tr data-entry-id="{{ $game->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $game->id ?? '' }}
                        </td>
                        <td>
                            <h4><span
                                class="badge {{  $game->status === 0 ? 'badge-warning' : ($game->status === 1 ? 'badge-success' : 'badge-danger') }}">{{  $game->status === 0 ? 'Offline' : ($game->status === 1 ? 'Active' : 'Ended') }}</span></h4>

                        </td>
                        <td>
                            {{ $game->game_name ?? '' }}
                        </td>
                        <td>
                            {{ $game->date ?? '' }}
                        </td>
                        <td>
                            {{ $game->ground ?? '' }}
                        </td>
                        <td>
                            <img height="80px" src="/storage/images/game_logo/{{ $game->game_logo }}" alt="">
                        </td>
                        <td>
                            {{ $teams->where('id', $game->team_a)->first()->team_name }}
                        </td>
                        <td>
                            {{ $teams->where('id', $game->team_b)->first()->team_name }}
                        </td>
                        <td>
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.games.show', $game->id) }}">
                                {{ trans('global.view') }}
                            </a>

                            <a class="btn btn-xs btn-info" href="{{ route('admin.games.edit', $game->id) }}">
                                {{ trans('global.edit') }}
                            </a>

                            <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST"
                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>

@endsection

@section('scripts')

@parent

<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        let deleteButtonTrans = "{{ trans('global.datatables.delete') }}"
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.permissions.mass_destroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')

                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: { 'x-csrf-token': _token },
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    })
                        .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)

        $.extend(true, $.fn.dataTable.defaults, {
            order: [[1, 'desc']],
            pageLength: 100,
        });
        $('.datatable-Permission:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });

</script>

@endsection