<div class="modal-header" style="padding-bottom: 0;">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4>Add / View Transactions</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="alert alert-success" style="display:none;"></div>
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
                        {{ Form::open(['route' => 'admin.childtransactions.creditamount', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'credit-amount']) }}
                            <input type="hidden" name="member_id" value="<?php echo encryptMethod($data['transaction_history_array'][0]['member_id']); ?>">
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
                            <div class="col-sm-6" style="padding: 35px 0 0 16px;text-align: left;">
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
                                    @elseif ($transaction['trans_type'] == '2')
                                        <td style="background-color:#ff9292;">&#x20B9; {{ $transaction['amount'] }}</td>
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
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
</div>

<script type="text/javascript">
    $(document).ready(function(){
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
                    url: '{{ route("admin.childtransactions.creditamount") }}',
                    type: "post",
                    data: formData
                });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR){
                    var response = JSON.parse(response);
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

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    // Log the error to the console
                    console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                    );
                });

                /* $('#advance_search').addClass('btn label-success');
                $('#export-buttons').removeClass('hide');
                $('.transparent-bg input').val('');
                $('#advance_search_remove').addClass('remove-advance_search');
                $('.preset-filter-dp').addClass('btn-primary');
                $('.preset-filter-dp').removeClass('btn-warning');
                $('#filterId').text('Filter'); */
            }, 100);
        });
    });
</script>