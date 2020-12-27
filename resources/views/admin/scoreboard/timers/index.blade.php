@extends('layouts.admin')

@section('content')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.timers.create") }}">
            Add Timer
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Timer List
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
                            Timer Name
                        </th>
                        <th>
                            Time Duration
                        </th>
                        <th>
                            Start Whistle
                        </th>
                        <th>
                            End Whistle
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($timers as $key => $timer)
                    <tr data-entry-id="{{ $timer->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $timer->id ?? '' }}
                        </td>
                        <td>
                            {{ $timer->timer_name ?? '' }}
                        </td>
                        <td>
                            {{ $timer->time ?? '' }}
                        </td>
                        <td>
                            <audio controls>
                                <source
                                    src="/storage/sounds/whistle_clips/{{ $whistles->find($timer->start_whistle_id)->soundclip ?? ''}}"
                                    type="audio/mpeg">
                            </audio>
                            {{-- {{ $timer->whistle_id ?? '' }} --}}
                        </td>
                        <td>
                            <audio controls>
                                <source
                                    src="/storage/sounds/whistle_clips/{{ $whistles->find($timer->end_whistle_id)->soundclip ?? ''}}"
                                    type="audio/mpeg">
                            </audio>
                            {{-- {{ $timer->whistle_id ?? '' }} --}}
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

                if (ids.length == 0) {
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