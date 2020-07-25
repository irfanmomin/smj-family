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
                            <th>{{ trans('labels.backend.family.table.fullname') }}</th>
                            <th>{{ trans('labels.backend.family.table.firstname') }}</th>
                            <th>{{ trans('labels.backend.family.table.areacity') }}</th>
                            <th>{{ trans('labels.backend.family.table.area') }}</th>
                            <th>{{ trans('labels.backend.family.table.is_verified') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th>{!! Form::text('fullname', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.family.table.fullname')]) !!}</th>
                            <th>{!! Form::text('areacity', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.family.table.areacity')]) !!}</th>
                            <th>{!! Form::text('is_verified', null, ["class" => "search-input-text form-control", "data-column" => 4, "placeholder" => trans('labels.backend.family.table.is_main_ph')]) !!}</th>
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
                    {data: 'fullname', name: 'fullname'},
                    {data: 'firstname', name: 'firstname', sortable: true},
                    {data: 'areacity', name: 'areacity'},
                    {data: 'area', name: '{{config('smj.tables.family')}}.area'},
                    {data: 'is_verified', name: '{{config('smj.tables.family')}}.is_verified'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                columnDefs: [
                    { width: 200, targets: 0 },
                    { 'orderData':[1], 'targets': [0] },
                    {
                        'targets': [1],
                        'visible': false,
                        'searchable': false
                    },
                    { 'orderData':[3], 'targets': [2] },
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
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0,2]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0,2 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0,2 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0,2 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0,2 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection