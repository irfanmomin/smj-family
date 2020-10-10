<div class="modal-header" style="padding-bottom: 0;">
	<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
	<h4>Add / View Transactions</h4>
</div>
<div class="modal-body">
    <div class="loading" style="display:none;">
        <div class="loader"></div>
    </div>
    <div class="row">
        <div class="alert alert-success" style="display:none;"></div>
        <div class="alert alert-danger" style="display:none;"></div>
	    <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#home">Add Payment</a></li>
                <li><a href="#menu1">Transactions History</a></li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="col-sm-8">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td><strong>Member Name</strong></td>
                                <td>{{ $data['transaction_history_array'][0]['member_name'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Area / City</strong></td>
                                <td>{{ $data['transaction_history_array'][0]['areacity'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Pending Amount</strong></td>
                                <td><strong style="font-size: 15px;color: red;">&#x20B9; {{ $data['total_pending_amount'] }}</strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        {{ Form::open(['route' => 'admin.childtranslist.creditamount', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'credit-amount']) }}
                            <input type="hidden" name="member_id" value="<?php echo encryptMethod($data['transaction_history_array'][0]['member_id']); ?>">
                            {{-- Main Trans List --}}
                            <div class="col-sm-6">
                                <label for="main_trans_id" class="control-label required">{{ trans('labels.backend.eventmaintrans.validation.main_trans_id') }} <span id="main_trans_pending_amount"></span></label>
                                {!! Form::select('main_trans_id', $data['events_list'], null, ["class" => "form-control box-size", "id" => "main_trans_id_selectbox", "data-id" => encryptMethod($data['transaction_history_array'][0]['member_id']), "data-column" => 2, "placeholder" => trans('labels.backend.eventmaintrans.validation.main_trans_id'), 'required' => 'required']) !!}
                            </div>
                            {{-- amount --}}
                            <div class="col-sm-6">
                                {{ Form::label('amount', trans('labels.backend.eventmaintrans.validation.creditamount'), ['class' => 'control-label required']) }}
                                {{ Form::text('amount', null, ['class' => 'form-control box-size', 'pattern' => '^\$?[0-9]?((\.[0-9]+)|([0-9]+(\.[0-9]+)?))$', 'title' => 'Please enter proper Amount', 'placeholder' => trans('labels.backend.eventmaintrans.validation.creditamount'), 'required' => 'required']) }}
                            </div>
                            <div class="col-sm-6">
                                {{ Form::label('receipt_no', trans('labels.backend.events-subcategory.validation.receipt_no'), ['class' => 'control-label']) }}
                                {{ Form::text('receipt_no', null, ['class' => 'form-control box-size', 'pattern' => '^[a-zA-Z0-9-_ ]*$', 'title' => 'Please enter proper name', 'placeholder' => trans('labels.backend.events-subcategory.validation.receipt_no')]) }}
                            </div>
                            <div class="col-sm-6">
                                {{ Form::label('Notes', trans('labels.backend.events-subcategory.validation.notes'), ['class' => 'control-label required']) }}
                                {{ Form::textarea('note', null,['class' => 'form-control', 'rows' => '2', 'cols' => '5', 'placeholder' => trans('labels.backend.events-subcategory.validation.notes'), 'required' => 'required']) }}
                            </div>
                            {{-- New Member DOB --}}
                            <div class="col-sm-6">
                                {{ Form::label('transaction_date', trans('labels.backend.family.validation.transaction_date'), ['class' => 'control-label']) }}

                                <div class="dateclass">
                                    <div class="date-block">
                                        <div class="input-group input-group-custom border-none">
                                            <input class="form-control eremitdatepicker" name="transaction_date" id="transaction_date" placeholder="DOB (dd-mm-yyyy)" value="{{ date('d-m-Y') }}" type="text">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--form control-->
                            <div class="col-sm-12" style="padding: 35px 0 0 16px;text-align: left;">
                                {{ Form::submit(trans('labels.backend.events-subcategory.buttons.submit'), ['class' => 'btn btn-success btn-md']) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-sm">Sub Category
                                </th>
                                <th class="th-sm">Note
                                </th>
                                <th class="th-sm">Receipt No.
                                </th>
                                <th class="th-sm">Transaction By
                                </th>
                                <th class="th-sm">Transaction Date
                                </th>
                                <th class="th-sm">Amount
                                </th>
                                <th class="th-sm">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['transaction_history_array'] as $transaction)
                                <tr>
                                    <td>{{ $transaction['sub_category_name'] }}</td>
                                    <td>{{ $transaction['note'] }}</td>
                                    <td>{{ $transaction['receipt_no'] }}</td>
                                    <td>{{ $transaction['creatorName'] }}</td>
                                    <td>{{ date("d/m/Y h:i A", strtotime($transaction['created_at'])) }}</td>
                                    @if ($transaction['trans_type'] == '1')
                                        <td style="background-color:#89cf89;">&#x20B9; {{ $transaction['amount'] }}</td>
                                        <td><a href="javascript:void(0)" class="btn btn-flat btn-danger dlt-credited-trans" id="dlt-credited-trans" data-id="<?php echo encryptMethod($transaction['id']) ?>">
                                            <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
                                    </a></td>
                                    @elseif ($transaction['trans_type'] == '2')
                                        <td style="background-color:#ff9292;">&#x20B9; {{ $transaction['amount'] }}</td>
                                        <td><?php /* <a href="javascript:void(0);" data-id="<?php echo encryptMethod($transaction['id']) ?>"
                                        class="btn btn-flat btn-danger" id="dlt-debited-trans">
                                            <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
                                    </a> */ ?></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.loading').hide();
        SMJ.Utility.Datepicker.init();
        $('#dtBasicExample').DataTable( {
            "order": [[ 4, "asc" ]],
            responsive: true,
            'destroy': true
        } );
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });

        $('#credit-amount').on('submit', function(e) {
            e.preventDefault();
            setTimeout(() => {
                var formData = $('#credit-amount').serializeArray();

                // Fire off the request to /form.php
                request = $.ajax({
                    url: '{{ route("admin.childtranslist.creditamount") }}',
                    type: "post",
                    data: formData
                });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR){
                    var response = JSON.parse(response);
                    console.log(response.hasOwnProperty('error') && response.error != '');
                    // Log a message to the console
                    if (response.hasOwnProperty('message') && response.message != '') {
                        var id = '<?php echo $data['transaction_history_array'][0]['member_id'] ?>';

                        //$( 'btn-mem-'+id ).trigger( "click" );
                        $('.alert.alert-success').removeAttr('style');
                        $('.alert.alert-success').html(response.message);
                        $('.alert.alert-success').show();
                        setTimeout(function() {
                            $('.alert.alert-success').fadeOut();
                        }, 3000);

                        var target = '<?php echo route('admin.family.addpaymentmodal', $data['transaction_history_array'][0]['member_id']) ?>';

                        // load the url and show modal on success
                        jQuery("#convertedInfoModal .modal-content").load(target, function() {
                            jQuery("#convertedInfoModal").modal("show");
                        });
                    } else if (response.hasOwnProperty('error') && response.error != '') {
                        var id = '<?php echo $data['transaction_history_array'][0]['member_id'] ?>';

                        //$( 'btn-mem-'+id ).trigger( "click" );
                        $('.alert.alert-danger').removeAttr('style');
                        $('.alert.alert-danger').html(response.error);
                        $('.alert.alert-danger').show();
                        setTimeout(function() {
                            $('.alert.alert-danger').fadeOut();
                        }, 4000);
                    }
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    // Log the error to the console
                    console.log(
                        "The following error occurred: "+
                        textStatus);
                        console.log(
                        "The following error occurred: "+
                        jqXHR);
                        console.log(
                        "The following error occurred: "+
                        errorThrown);
                });
            }, 100);
        });

        $('#dlt-debited-trans').on('click', function(e) {
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
                        var id = '<?php echo $data['transaction_history_array'][0]['member_id'] ?>';

                        //$( 'btn-mem-'+id ).trigger( "click" );
                        $('.alert.alert-success').removeAttr('style');
                        $('.alert.alert-success').html(response.message);
                        $('.alert.alert-success').show();
                        setTimeout(function() {
                            $('.alert.alert-success').fadeOut();
                        }, 3000);

                        var target = '<?php echo route('admin.family.addpaymentmodal', $data['transaction_history_array'][0]['member_id']) ?>';

                        // load the url and show modal on success
                        jQuery("#convertedInfoModal .modal-content").load(target, function() {
                            jQuery("#convertedInfoModal").modal("show");
                        });
                    }
                });
            }
        });

        $('#main_trans_id_selectbox').on('change', function(e) {
            $('.loading').show();
            var main_trans_id = $(this).val();

            if ($(this).data('id') != undefined && $(this).data('id') != '') {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("admin.childtranslist.getpendingamount") }}',
                    data: { main_trans_id: main_trans_id, member_id: $(this).data('id') }
                }).done(function( result ) {
                    var response = JSON.parse(result);
                    $('.loading').hide();
                    if (response.hasOwnProperty('pending_amount') && response.pending_amount != '') {
                        $('#main_trans_pending_amount').html('(Pending Amount: <strong style="color: #ff7514">&#x20B9; '+response.pending_amount+'</strong>)');
                    } else if (response.hasOwnProperty('error') && response.error != '') {
                        //$( 'btn-mem-'+id ).trigger( "click" );
                        $('.alert.alert-danger').removeAttr('style');
                        $('.alert.alert-danger').html(response.error);
                        $('.alert.alert-danger').show();
                        $('#main_trans_pending_amount').html('');
                        setTimeout(function() {
                            $('.alert.alert-danger').fadeOut();
                        }, 4000);
                    }
                }).fail(function() {
                    $('.loading').hide();
                    $('#main_trans_pending_amount').html('');
                });
            } else {
                $('.loading').hide();
                $('#main_trans_pending_amount').html('');
            }
        });

        $('.dlt-credited-trans').on('click', function(e) {
            e.preventDefault();

            var result = confirm("Are you sure you want to delete?");
            if (!result) {
                return;
            }

            if ($(this).data('id') != undefined && $(this).data('id') != '') {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("admin.childtranslist.deletecreditedtrans") }}',
                    data: { id: $(this).data('id') }
                }).done(function( result ) {
                    var response = JSON.parse(result);
                    console.log('response', response);
                    // Log a message to the console
                    if (response.message != '') {
                        var id = '<?php echo $data['transaction_history_array'][0]['member_id'] ?>';

                        //$( 'btn-mem-'+id ).trigger( "click" );
                        $('.alert.alert-success').removeAttr('style');
                        $('.alert.alert-success').html(response.message);
                        $('.alert.alert-success').show();
                        setTimeout(function() {
                            $('.alert.alert-success').fadeOut();
                        }, 3000);

                        var target = '<?php echo route('admin.family.addpaymentmodal', $data['transaction_history_array'][0]['member_id']) ?>';

                        // load the url and show modal on success
                        jQuery("#convertedInfoModal .modal-content").load(target, function() {
                            jQuery("#convertedInfoModal").modal("show");
                        });
                    }
                });
            }
        });
    });
</script>