@extends('layouts.admin')

@section('content')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        {{-- <a class="btn btn-success" href="{{ route("admin.timers.create") }}">
        Add Timer
        </a> --}}
    </div>
</div>

<div class="card">
    <div class="card-header">
        Scoreboard List
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
                            Game Id
                        </th>
                        <th>
                            Score Team A
                        </th>
                        <th>
                            Score Team B
                        </th>
                        <th>
                            Time
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Timer Id
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($scoreboards as $key => $scoreboard)
                    <tr data-entry-id="{{ $scoreboard->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $scoreboard->id ?? '' }}
                        </td>
                        <td>
                            {{ $scoreboard->game_id ?? '' }}
                        </td>
                        <td>
                            {{ $scoreboard->score_team_a ?? '' }}
                        </td>
                        <td>
                            {{ $scoreboard->score_team_b ?? '' }}
                        </td>
                        <td>
                            {{ $scoreboard->time ?? '' }}
                        </td>
                        <td>
                            {{ $scoreboard->status ?? '' }}
                        </td>
                        <td>
                            {{ $scoreboard->timer_id ?? '' }}
                        </td>

                        <td>
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.timers.show', $timer->id) }}">
                                {{ trans('global.view') }}
                            </a>

                            <a class="btn btn-xs btn-info" href="{{ route('admin.timers.edit', $timer->id) }}">
                                {{ trans('global.edit') }}
                            </a>

                            <form action="{{ route('admin.timers.destroy', $timer->id) }}" method="POST"
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