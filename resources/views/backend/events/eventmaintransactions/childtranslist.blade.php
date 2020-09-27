@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.childtranslist.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.childtranslist.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.childtranslist.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.events.eventmaintransactions.partials.childtranslist-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="childtranslist-table" class="table table-condensed table-hover table-bordered responsive">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.childtranslist.table.member_name') }}</th>
                            <th>{{ trans('labels.backend.childtranslist.table.sub_category_name') }}</th>
                            <th>{{ trans('labels.backend.childtranslist.table.amount') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th>{!! Form::text('member_name', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.childtranslist.table.member_name')]) !!}</th>
                            <th>{!! Form::text('sub_category_name', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.childtranslist.table.sub_category_name')]) !!}</th>
                            <th>{!! Form::text('amount', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.childtranslist.table.amount')]) !!}</th>
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
            var dataTable = $('#childtranslist-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                'destroy': true,
                'autoWidth': false,
                ajax: {
                    url: '{{ route("admin.childtranslist.get") }}',
                    type: 'post',
                    data: param
                },
                columns: [
                    {data: 'member_name', name: 'member_name'},
                    {data: 'sub_category_name', name: '{{config('smj.tables.eventssubcategory')}}.sub_category_name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'action_unreserve', name: 'action_unreserve', searchable: false, sortable: false},
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
            generateDataTable({formData: ['<?php echo $id ?>']});
            $('#childtranslist_advance_search').on('submit', function(e) {
                e.preventDefault();
                var formData = $('#childtranslist_advance_search').serializeArray();
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