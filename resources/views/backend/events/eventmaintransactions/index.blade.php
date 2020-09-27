@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.eventmaintrans.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.eventmaintrans.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.eventmaintrans.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.events.eventmaintransactions.partials.eventmaintrans-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="eventmaintrans-table" class="table table-condensed table-hover table-bordered responsive">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.eventmaintrans.table.category_name') }}</th>
                            <th>{{ trans('labels.backend.eventmaintrans.table.sub_category_name') }}</th>
                            <th>{{ trans('labels.backend.eventmaintrans.table.amount') }}</th>
                            <th>{{ trans('labels.backend.eventmaintrans.table.event_group_name') }}</th>
                            <th>{{ trans('labels.backend.eventmaintrans.table.created_at') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th>{!! Form::text('category_name', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.eventmaintrans.table.category_name')]) !!}</th>
                            <th>{!! Form::text('sub_category_name', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.eventmaintrans.table.sub_category_name')]) !!}</th>
                            <th>{!! Form::text('amount', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.eventmaintrans.table.amount')]) !!}</th>
                            <th>{!! Form::text('event_group_name', null, ["class" => "search-input-text form-control", "data-column" => 3, "placeholder" => trans('labels.backend.eventmaintrans.table.event_group_name')]) !!}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        function generateDataTable(param = {}) {
            var dataTable = $('#eventmaintrans-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                'destroy': true,
                'autoWidth': false,
                ajax: {
                    url: '{{ route("admin.maintransactions.get") }}',
                    type: 'post',
                    data: param
                },
                columns: [
                    {data: 'category_name', name: '{{config('smj.tables.eventscategory')}}.category_name'},
                    {data: 'sub_category_name', name: '{{config('smj.tables.eventssubcategory')}}.sub_category_name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'event_group_name', name: '{{config('smj.tables.eventsgroup')}}.event_group_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[3, "desc"]],
                searchDelay: 500,
                columnDefs: [
                    { width: 280, targets: 0 },
                ],
                fixedColumns: true,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 2]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 2 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 2 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 2 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 2 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        }

        $(function() {
            generateDataTable({formData: []});
            $('#eventmaintrans_advance_search').on('submit', function(e) {
                e.preventDefault();
                var formData = $('#eventmaintrans_advance_search').serializeArray();
                console.log(formData);
                generateDataTable({formData: formData});
            });

            $('#verify-select').on('change', function() {
                var $form = $(this).closest('form');
                $form.find('input[type=submit]').click();
            });
        });

    </script>
@endsection