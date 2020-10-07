@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.family.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.family.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.family.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.family.partials.family-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="family-table" class="table table-condensed table-hover table-bordered responsive">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.family.table.main_family_id') }}</th>
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
                            <th>{!! Form::text('main_family_id', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.family.table.main_family_id')]) !!}</th>
                            <th>{!! Form::text('fullname', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.family.table.fullname')]) !!}</th>
                            <th>{!! Form::text('areacity', null, ["class" => "search-input-text form-control", "data-column" => 3, "placeholder" => trans('labels.backend.family.table.areacity')]) !!}</th>
                            <th>{!! Form::text('is_verified', null, ["class" => "search-input-text form-control", "data-column" => 5, "placeholder" => trans('labels.backend.family.table.is_verified')]) !!}</th>
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
            var dataTable = $('#family-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                lengthMenu: [[25, 100, -1], [25, 100, "All"]],
                'destroy': true,
                'autoWidth': false,
                ajax: {
                    url: '{{ route("admin.family.get") }}',
                    type: 'post',
                    data: param
                },
                /* bStateSave: true,
                fnStateSave: function (oSettings, oData) {
                    localStorage.setItem( 'DataTables_'+window.location.pathname, JSON.stringify(oData) );
                },
                fnStateLoad: function (oSettings) {
                    return JSON.parse( localStorage.getItem('DataTables_'+window.location.pathname) );
                }, */
                columns: [
                    {data: 'main_family_id', name: 'main_family_id'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'firstname', name: 'firstname', sortable: true},
                    {data: 'areacity', name: 'areacity'},
                    {data: 'area', name: '{{config('smj.tables.family')}}.area'},
                    {data: 'is_verified', name: '{{config('smj.tables.family')}}.is_verified'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[2, "asc"]],
                searchDelay: 500,
                columnDefs: [
                    { width: 50, targets: 0 },
                    { 'orderData':[2], 'targets': [1] },
                    {
                        'targets': [2],
                        'visible': false,
                        'searchable': false
                    },
                    { 'orderData':[4], 'targets': [3] },
                    {
                        'targets': [4],
                        'visible': false,
                        'searchable': false
                    },
                ],
                fixedColumns: true,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 3]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 3 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 3 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 3 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 3 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        }

        $(function() {
            generateDataTable({formData: []});
            $('#family_advance_search').on('submit', function(e) {
                e.preventDefault();
                var formData = $('#family_advance_search').serializeArray();
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