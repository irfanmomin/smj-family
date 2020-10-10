@extends ('backend.layouts.app')

@php
$title = $mainTransDetails['sub_category_name']. ' (₹ '.$mainTransDetails['amount'].')';
@endphp
@section ('title', $mainTransDetails['sub_category_name'])

@section('page-header')
    <h1>{{ $mainTransDetails['sub_category_name'] }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $mainTransDetails['sub_category_name'] }}</h3> &nbsp;&nbsp;&nbsp;
            <span><strong>Amount: </strong>&#x20B9; {{ $mainTransDetails['amount'] }}</span>

            <div class="box-tools pull-right">
                @include('backend.events.eventmaintransactions.partials.childtranslist-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="modal fade" id="convertedInfoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default cancel-btn-update" data-dismiss="modal">Exit</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive data-table-wrapper">
                <table id="childtranslist-table" class="table table-condensed table-hover table-bordered responsive">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.childtranslist.table.main_family_id') }}</th>
                            <th>{{ trans('labels.backend.childtranslist.table.member_name') }}</th>
                            <th>{{ trans('labels.backend.childtranslist.table.areacity') }}</th>
                            <th>{{ trans('labels.backend.childtranslist.table.pending_amount') }}</th>
                            <th>{{ trans('labels.backend.childtranslist.table.pending_amount') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <thead class="transparent-bg">
                        <tr>
                            <th>{!! Form::text('main_family_id', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.childtranslist.table.main_family_id')]) !!}</th>
                            <th>{!! Form::text('member_name', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.childtranslist.table.member_name')]) !!}</th>
                            <th>{!! Form::text('areacity', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.childtranslist.table.areacity')]) !!}</th>
                            <th>{!! Form::select('pending_amount_hidden', getPendingAmountLabels(), null, ["class" => "search-input-select form-control", "data-column" => 3]) !!}</th>
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
                pageLength: 25,
                'destroy': true,
                'autoWidth': false,
                ajax: {
                    url: '{{ route("admin.childtranslist.get") }}',
                    type: 'post',
                    data: param
                },
                /* bStateSave: true,
                fnStateSave: function (oSettings, oData) {
                    localStorage.setItem( 'DataTables_'+window.location.pathname, JSON.stringify(oData) );
                },
                fnStateLoad: function (oSettings) {
                    return JSON.parse( localStorage.getItem('DataTables_'+window.location.pathname) );
                } , */
                columns: [
                    {data: 'main_family_id', name: 'main_family_id'},
                    {data: 'member_name', name: 'member_name'},
                    {data: 'areacity', name: 'areacity'},
                    {data: 'pending_amount_hidden', name: 'pending_amount_hidden'},
                    {data: 'pending_amount', name: 'trans_pending_amount'},
                    {data: 'action_unreserve', name: 'action_unreserve', searchable: false, sortable: false},
                ],
                order: [[0, "asc"]],
                lengthMenu: [[25, 100, -1], [25, 100, "All"]],
                searchDelay: 500,
                columnDefs: [
                    { width: 50, targets: 0 },
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
                        { extend: 'copy', className: 'copyButton', title: '<?php echo $title; ?>',  exportOptions: {columns: [ 0, 1, 2, 3]  }},
                        { extend: 'csv', className: 'csvButton', title: '<?php echo $title; ?>',  exportOptions: {columns: [ 0, 1, 2, 4 ]  }},
                        { extend: 'excel', className: 'excelButton', title: '<?php echo $title; ?>',  exportOptions: {columns: [ 0, 1, 2, 4 ]  }},
                        { extend: 'pdf', className: 'pdfButton', title: '<?php echo $title; ?>',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'print', className: 'printButton', title: '<?php echo $title; ?>',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }}
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

        $(document).on('click','.cancel-btn-update', function(e) {
            generateDataTable({formData: ['<?php echo $id ?>']});
        });

        $(document).on('click','.dlt-debited-trans', function(e) {
            console.log('fdsfdds');
            e.preventDefault();

            var result = confirm("Are you sure you want to delete?");
            if (!result) {
                return;
            }

            if ($(this).data('id') != undefined && $(this).data('id') != '') {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("admin.childtranslist.deletetrans") }}',
                    data: { id: $(this).data('id') }
                }).done(function( response ) {
                    var response = JSON.parse(response);
                    console.log('response', response);
                    // Log a message to the console
                    if (response.message != '') {
                        $('#childtranslist-table').DataTable().destroy();
                        setTimeout(() => {
                            alert(response.message);
                        }, 500);
                        $(".select-all").prop("checked", false);
                        generateDataTable({formData: ['<?php echo $id ?>']});
                    }
                });
            }
        });

    </script>
@endsection