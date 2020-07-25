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
                            <th>{!! Form::text('is_verified', null, ["class" => "search-input-text form-control", "data-column" => 4, "placeholder" => trans('labels.backend.family.table.is_verified')]) !!}</th>
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
                pageLength: 10,
                'destroy': true,
                'autoWidth': false,
                ajax: {
                    url: '{{ route("admin.family.get") }}',
                    type: 'post',
                    data: param
                },
                columns: [
                    {data: 'fullname', name: 'fullname'},
                    {data: 'firstname', name: 'firstname', sortable: true},
                    {data: 'areacity', name: 'areacity'},
                    {data: 'area', name: '{{config('smj.tables.family')}}.area'},
                    {data: 'is_verified', name: '{{config('smj.tables.family')}}.is_verified'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[1, "asc"]],
                searchDelay: 500,
                columnDefs: [
                    { width: 280, targets: 0 },
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