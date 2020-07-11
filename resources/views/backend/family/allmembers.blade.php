@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.allmembers.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.allmembers.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.allmembers.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.family.partials.allmembers-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="allmembers-table" class="table table-condensed table-hover table-bordered responsive">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.general.actions') }}</th>
                            <th>{{ trans('labels.backend.family.table.fullname') }}</th>
                            <th>{{ trans('labels.backend.family.table.firstname') }}</th>
                            <th>{{ trans('labels.backend.family.table.area') }}</th>
                            <th>{{ trans('labels.backend.family.table.city') }}</th>
                            <th>{{ trans('labels.backend.family.table.is_main') }}</th>
                            <th>{{ trans('labels.backend.family.table.created_by') }}</th>
                            <th>{{ trans('labels.backend.family.table.created_at') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th></th>
                            <th>{!! Form::text('fullname', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.family.table.fullname')]) !!}</th>
                            <th>{!! Form::text('area', null, ["class" => "search-input-text form-control", "data-column" => 3, "placeholder" => trans('labels.backend.family.table.area')]) !!}</th>
                            <th>{!! Form::text('city', null, ["class" => "search-input-text form-control", "data-column" => 4, "placeholder" => trans('labels.backend.family.table.city')]) !!}</th>
                            <th>{!! Form::text('is_main', null, ["class" => "search-input-text form-control", "data-column" => 5, "placeholder" => trans('labels.backend.family.table.is_main_ph')]) !!}</th>
                            <th>{!! Form::text('created_by', null, ["class" => "search-input-text form-control", "data-column" => 6, "placeholder" => trans('labels.backend.family.table.created_by')]) !!}</th>
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
        //Below written line is short form of writing $(document).ready(function() { })
        $(document).ready(function() {
            var dataTable = $('#allmembers-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("admin.allmembers.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'firstname', name: 'firstname', sortable: true},
                    {data: 'area', name: '{{config('smj.tables.family')}}.area'},
                    {data: 'city', name: '{{config('smj.tables.family')}}.city'},
                    {data: 'is_main', name: '{{config('smj.tables.family')}}.is_main'},
                    {data: 'creatorName', name: 'creatorName'},
                    {data: 'created_at', name: '{{config('smj.tables.family')}}.created_at'},
                ],
                order: [[7, "desc"]],
                searchDelay: 500,
                columnDefs: [
                    { width: 75, targets: 0 },
                    { 'orderData':[2], 'targets': [1] },
                    {
                        'targets': [2],
                        'visible': false,
                        'searchable': false
                    },
                ],
                fixedColumns: true,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 1, 2, 3]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 1, 2, 3 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 1, 2, 3 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 1, 2, 3 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 1, 2, 3 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection