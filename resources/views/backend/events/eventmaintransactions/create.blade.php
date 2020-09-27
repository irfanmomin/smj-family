@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.eventmaintrans.newmanagement') . ' | ' . trans('labels.backend.eventmaintrans.new'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.eventmaintrans.new') }}
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.maintransactions.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-new-eventmaintrans']) }}
        <div class="box box-info">
            <div class="box-body">
                <div class="loading" style="display:none;">
                    <div class="loader"></div>
                </div>
                {{-- Event Category --}}
                <div class="form-group">
                    {{ Form::label('category_id', trans('labels.backend.eventmaintrans.validation.category_id'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('category_id', $mainEventCategoriesList, null, ["class" => "form-control box-size", "data-column" => 2, "placeholder" => trans('labels.backend.eventmaintrans.validation.category_id'), 'required' => 'required']) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Event Category --}}
                <div class="form-group">
                    {{ Form::label('sub_category_id', trans('labels.backend.eventmaintrans.validation.sub_category_id'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('sub_category_id', [], null, ["class" => "form-control box-size", "data-column" => 2, "placeholder" => trans('labels.backend.eventmaintrans.validation.sub_category_id'), 'required' => 'required']) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Event Group --}}
                <div class="form-group">
                    {{ Form::label('event_group', trans('labels.backend.eventmaintrans.validation.event_group'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        <p id="event_group_label"></p>
                        <input type="hidden" id="hdn_event_group_id" value="" name="event_group_id" />
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- amount --}}
                <div class="form-group">
                    {{ Form::label('amount', trans('labels.backend.eventmaintrans.validation.amount'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('amount', null, ['class' => 'form-control box-size', 'pattern' => '^[0-9.]*$', 'title' => 'Please enter proper Amount', 'placeholder' => trans('labels.backend.eventmaintrans.validation.amount_ph'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Including Form blade file --}}
                <div class="form-group">
                    <div class="edit-form-btn">
                    {{ link_to_route('admin.maintransactions.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    <!-- <a class="btn btn-success btn-md" id="eventmaintrans-main-form-next" href="javascript:void(0);" title="eventmaintrans-main-form-next">Submit</a> -->
                    {{ Form::submit(trans('labels.backend.eventmaintrans.buttons.create'), ['class' => 'btn btn-success btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection

@section('after-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            SMJ.Family.init();
            SMJ.Utility.Datepicker.init();

            $(document).on('change', '#category_id', function() {
                console.log('fsdfs');
                $('.loading').show();
                var categoryID = $(this).val();

                $.ajax({
                    url: '{{ route("admin.maintransactions.getsubcategorylist") }}',
                    type: "get",
                    dataType: "json",
                    sync: true,
                    data: {
                        categoryID: categoryID
                    },
                    success: function(data) {
                        var output = [];
                        var count = 0;

                        $.each(data[0], function(k , value) {
                            if (count == 0) {
                                output.push('<option value="">Choose Sub Category</option>');
                            }

                            count++;
                            output.push('<option value="'+ k +'">'+ value +'</option>');
                        });

                        $('#hdn_event_group_id').val(data[2]);
                        $('#sub_category_id').html(output.join(''));
                        $('#event_group_label').html(data[1]);
                        $('.loading').hide();
                        return true;
                    },
                });
            });
        });
    </script>
@endsection
