@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.events-subcategory.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.events-subcategory.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.events-subcategory.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.events.subcategories.partials.events-subcategory-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="events-subcategory-table" class="table table-condensed table-hover table-bordered responsive">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.events-subcategory.table.sub_category_name') }}</th>
                            <th>{{ trans('labels.backend.events-subcategory.table.category_id') }}</th>
                            <th>{{ trans('labels.backend.events-subcategory.table.event_group_id') }}</th>
                            <th>{{ trans('labels.backend.events-subcategory.table.created_at') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th>{!! Form::text('sub_category_name', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.events-subcategory.table.sub_category_name')]) !!}</th>
                            <th>{!! Form::text('category_id', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.events-subcategory.table.category_id')]) !!}</th>
                            <th>{!! Form::text('event_group_id', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.events-subcategory.table.event_group_id')]) !!}</th>
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
            var dataTable = $('#events-subcategory-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                'destroy': true,
                'autoWidth': false,
                ajax: {
                    url: '{{ route("admin.subcategoriesmanagement.get") }}',
                    type: 'post',
                    data: param
                },
                columns: [
                    {data: 'sub_category_name', name: 'sub_category_name'},
                    {data: 'category_name', name: '{{config('smj.tables.eventscategory')}}.category_name'},
                    {data: 'event_group_name', name: '{{config('smj.tables.eventsgroup')}}.event_group_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[3, "desc"]],
                searchDelay: 500,
                columnDefs: [
                    { width: 280, targets: 0 },
                    {
                        'targets': [3],
                        'visible': false,
                        'searchable': false
                    },
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
            $('#events-subcategory_advance_search').on('submit', function(e) {
                e.preventDefault();
                var formData = $('#events-subcategory_advance_search').serializeArray();
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