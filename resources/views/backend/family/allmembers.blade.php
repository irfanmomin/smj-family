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
            <div class="modal fade" id="convertedInfoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"></div>
                </div>
            </div>
            <div class="table-responsive data-table-wrapper">
                <div class="toolbar"></div>
                <table id="allmembers-table" class="table table-condensed table-hover table-bordered responsive">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.family.table.fullname') }}</th>
                            <th>{{ trans('labels.backend.family.table.firstname') }}</th>
                            <th>{{ trans('labels.backend.family.table.areacity') }}</th>
                            <th>{{ trans('labels.backend.family.table.area') }}</th>
                            <th>{{ trans('labels.backend.family.table.is_verified') }}</th>
                            <th>{{ trans('labels.backend.family.table.is_main') }}</th>
                            <th>{{ trans('labels.backend.family.table.pending_amount') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th>{!! Form::text('fullname', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.family.table.fullname')]) !!}</th>
                            <th>{!! Form::text('areacity', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.family.table.areacity')]) !!}</th>
                            <th>{!! Form::text('is_verified', null, ["class" => "search-input-text form-control", "data-column" => 4, "placeholder" => trans('labels.backend.family.table.is_main_ph')]) !!}</th>
                            <th>{!! Form::text('is_main', null, ["class" => "search-input-text form-control", "data-column" => 5, "placeholder" => trans('labels.backend.family.table.is_main_ph')]) !!}</th>
                            <th>{!! Form::text('pending_amount', null, ["class" => "search-input-text form-control", "data-column" => 6, "placeholder" => trans('labels.backend.family.table.pending_amount')]) !!}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
            <!-- Advanced FILTERS -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">
                                ×
                            </button>
                            <h4 class="modal-title">
                                {{ trans('labels.backend.allmembers.advance_search') }}
                            </h4>
                        </div>
                        <div class="modal-body">
                        <!-- 'verified'        => 'Verified',
                        'unverified'      => 'Un-Verified',
                        'agelessthan'     => 'Age Less than',
                        'agegreaterthan'  => 'Age Greater than',
                        'male'            => 'Male',
                        'female'          => 'Female',
                        'onlymainmembers' => 'Only Main Members',
                        'expired'         => 'Expired Members',
                        'deleted'         => 'Deleted Members', -->
                            {{ Form::open(['route' => 'admin.allmembers.get', 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'allmembers_advance_search','autocomplete'=>'off']) }}
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-2 mb-2">
                                        {{ Form::label('agelessthan', trans('labels.backend.allmembers.agelessthan'), []) }}
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        {{ Form::text('agelessthan', null, ['class' => 'form-control','id'=>'agelessthan', 'placeholder' => trans('labels.backend.allmembers.agelessthan')]) }}
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        {{ Form::label('agegreaterthan', trans('labels.backend.allmembers.agegreaterthan'), []) }}
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        {{ Form::text('agegreaterthan', null, ['class' => 'form-control','id'=>'agegreaterthan', 'placeholder' => trans('labels.backend.allmembers.agegreaterthan')]) }}
                                    </div>
                                </div>
                                <!--col-lg-3-->
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        {{ Form::label('agenumber', trans('labels.backend.allmembers.agenumber'), []) }}
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        {{ Form::text('agenumber', null, ['class' => 'form-control','id'=>'agenumber', 'placeholder' => trans('labels.backend.allmembers.agenumber')]) }}
                                    </div>
                                    <div class="col-md-1 mb-3">
                                        At
                                    </div>
                                    <div class="col-md-7 mb-3">
                                        {{ Form::text('age_on', null, ['class' => 'nulldatepicker form-control','id'=>'age_on', 'placeholder' => trans('labels.backend.allmembers.age_on')]) }}
                                    </div>
                                </div>
                                <!--col-lg-3-->
                            </div>

                            <div class="form-group">
                                {{ Form::label('verifiedstatus', trans('labels.backend.allmembers.verifiedstatus'), ['class' => 'col-lg-2']) }}
                                <div class="col-lg-6">
                                    <div class="control-group">
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('verifiedstatus', 'verified', false) }}
                                            <div class="control__indicator">
                                            </div>
                                            {{ trans('labels.backend.allmembers.verified') }}
                                        </label>
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('verifiedstatus', 'unverified', false) }}
                                            <div class="control__indicator">
                                            </div>
                                            {{ trans('labels.backend.allmembers.unverified') }}
                                        </label>
                                    </div>
                                </div>
                                <!--col-lg-3-->
                            </div>

                            <div class="form-group">
                                {{ Form::label('gender', trans('labels.backend.allmembers.gender'), ['class' => 'col-lg-2']) }}
                                <div class="col-lg-6">
                                    <div class="control-group">
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('gender', 'male', false) }}
                                            <div class="control__indicator">
                                            </div>
                                            {{ trans('labels.backend.allmembers.male') }}
                                        </label>
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('gender', 'female', false) }}
                                            <div class="control__indicator">
                                            </div>
                                            {{ trans('labels.backend.allmembers.female') }}
                                        </label>
                                    </div>
                                </div>
                                <!--col-lg-3-->
                            </div>

                            <div class="form-group">
                                {{ Form::label('onlymainmembers', trans('labels.backend.allmembers.onlymainmembers'), ['class' => 'col-lg-2']) }}
                                <div class="col-lg-6">
                                    <div class="control-group">
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('onlymainmembers', 'onlymainmembers', false) }}
                                            <div class="control__indicator">
                                            </div>
                                            {{ trans('labels.backend.allmembers.onlymainmembers') }}
                                        </label>
                                    </div>
                                </div>
                                <!--col-lg-3-->
                            </div>

                            <div class="form-group">
                                {{ Form::label('expired', trans('labels.backend.allmembers.expired'), ['class' => 'col-lg-2']) }}
                                <div class="col-lg-6">
                                    <div class="control-group">
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('expired', 'expired', false) }}
                                            <div class="control__indicator">
                                            </div>
                                            {{ trans('labels.backend.allmembers.expired') }}
                                        </label>
                                    </div>
                                </div>
                                <!--col-lg-3-->
                            </div>

                            <div class="form-group">
                                {{ Form::label('deleted', trans('labels.backend.allmembers.deleted'), ['class' => 'col-lg-2']) }}
                                <div class="col-lg-6">
                                    <div class="control-group">
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('deleted', 'deleted', false) }}
                                            <div class="control__indicator">
                                            </div>
                                            {{ trans('labels.backend.allmembers.deleted') }}
                                        </label>
                                    </div>
                                </div>
                                <!--col-lg-3-->
                            </div>
                            <div class="form-group">
                                <div class="col-lg-9">
                                </div>
                                <div class="col-lg-3 text-right">
                                <button class="btn btn-default" data-dismiss="modal" type="button">
                                {{ trans('labels.backend.allmembers.close') }}
                            </button>
                                    {{ Form::submit('Search', ['class' => 'btn btn-primary btn-md']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Advanced Filters -->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        function generateDataTable(param = {}) {
            var dataTable = $('#allmembers-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                'destroy': true,
                'autoWidth': false,
                ajax: {
                    url: '{{ route("admin.allmembers.get") }}',
                    type: 'post',
                    data: param
                },
                columns: [
                    {data: 'fullname', name: 'fullname'},
                    {data: 'firstname', name: 'firstname', sortable: true},
                    {data: 'areacity', name: 'areacity'},
                    {data: 'area', name: '{{config('smj.tables.family')}}.area'},
                    {data: 'is_verified', name: '{{config('smj.tables.family')}}.is_verified'},
                    {data: 'is_main', name: '{{config('smj.tables.family')}}.is_main'},
                    {data: 'pending_amount', name: 'pending_amount'},
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
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0,2,6]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0,2,6 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0,2,6 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0,2,6 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0,2,6 ]  }}
                    ]
                }
            });

            $("div.toolbar").html('<a id="advance_search_remove" style="display:none;"><i data-toggle="tooltip" data-placement="top" title="View" class="fa fa-close"></i></a><a id="advance_search" style="float:right;margin: 4px 5px;cursor: pointer;" data-toggle="modal" data-target="#myModal">Advance Search</a>');
            $('#allmembers-table_filter').css('display', 'none');
            $('#allmembers-table_filter').hide();
            Backend.DataTableSearch.init(dataTable);

            $(document).on('click', '#advance_search_remove', function(e) {
                e.preventDefault();
                $('#csvButton, .csvButton').unbind().click();
                $('#pdfButton, .pdfButton').unbind().click();
                generateDataTable({formData: []});
                $('#advance_search').removeClass('btn label-success');
                $('#advance_search_remove').removeClass('remove-advance_search');
                $('#allmembers_advance_search')[0].reset();
                $('#approved_by_system, #approved_by_manual').prop("checked", false);
                $('#approved_by_system, #approved_by_manual').attr('onclick',"return false;");
            });
        }

        $(function() {
            $('#allmembers-table_filter').hide();

            $(document).on('click', '#advance_search_remove', function(e) {
                e.preventDefault();
                $('#csvButton, .csvButton').unbind().click();
                $('#pdfButton, .pdfButton').unbind().click();
                generateDataTable({formData: []});
                $('.transparent-bg input').val('');
                $('#advance_search').removeClass('btn label-success');
                $('#advance_search_remove').removeClass('remove-advance_search');
                $('#allmembers_advance_search')[0].reset();
                $('#approved_by_system, #approved_by_manual').prop("checked", false);
                $('#approved_by_system, #approved_by_manual').attr('onclick',"return false;");
            });

            $(".nulldatepicker").dateDropdowns({
                defaultDate: null,
                defaultDateFormat:"dd-mm-yyyy",
                submitFormat: "dd-mm-yyyy",
                monthFormat: "short",
                daySuffixes: false,
            });

            generateDataTable({formData: []});

            $('#refresh').on( 'click', function (e) {
                $('#allmembers-table').DataTable().ajax.reload(null, false);
            });

            $('.date-dropdowns select.day, .date-dropdowns select.month, .date-dropdowns select.year').addClass('custom-date-dropdown form-control');

            $('#allmembers_advance_search').on('submit', function(e) {
                e.preventDefault();
                setTimeout(() => {
                    var formData = $('#allmembers_advance_search').serializeArray();
                    generateDataTable({formData: formData});
                    $('#myModal').modal('hide');
                    $('#advance_search').addClass('btn label-success');
                    $('#export-buttons').removeClass('hide');
                    $('.transparent-bg input').val('');
                    $('#advance_search_remove').addClass('remove-advance_search');
                    $('.preset-filter-dp').addClass('btn-primary');
                    $('.preset-filter-dp').removeClass('btn-warning');
                    $('#filterId').text('Filter');
                }, 1000);
            });

            /* $('#allmembers_advance_search').on('submit', function(e) {
                e.preventDefault();
                var formData = $('#allmembers_advance_search').serializeArray();
                console.log(formData);
                generateDataTable({formData: formData});
            }); */

            /* $('#verify-select').on('change', function() {
                var $form = $(this).closest('form');
                $form.find('input[type=submit]').click();
            }); */

            jQuery(document).on("click", ".btn-credit-payment-modal", function(ev){
                ev.preventDefault();
                var target = jQuery(this).attr("href");

                // load the url and show modal on success
                jQuery("#convertedInfoModal .modal-content").load(target, function() {
                    jQuery("#convertedInfoModal").modal("show");
                });
            });
            jQuery(".modal").on("hidden.bs.modal", function(){
            jQuery("#convertedInfoModal .modal-content").html("");
            });
        });

    </script>
@endsection