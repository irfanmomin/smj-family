@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.events-subcategory.newmanagement') . ' | ' . trans('labels.backend.events-subcategory.new'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.events-subcategory.new') }}
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.eventsubcategories.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-new-events-subcategory']) }}
        <div class="box box-info">
            <div class="box-body">
                <div class="loading" style="display:none;">
                    <div class="loader"></div>
                </div>
                {{-- Event Category --}}
                <div class="form-group">
                    {{ Form::label('category_id', trans('labels.backend.events-subcategory.validation.category_id'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('category_id', $mainEventCategoriesList, null, ["class" => "form-control box-size", "data-column" => 2, "placeholder" => trans('labels.backend.events-subcategory.validation.category_id'), 'required' => 'required']) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- sub_category_name --}}
                <div class="form-group">
                    {{ Form::label('sub_category_name', trans('labels.backend.events-subcategory.validation.sub_category_name'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('sub_category_name', null, ['class' => 'form-control box-size', 'pattern' => '^[a-zA-Z0-9-_ ]*$', 'title' => 'Please enter proper name', 'placeholder' => trans('labels.backend.events-subcategory.validation.sub_category_name_ph'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Event Group --}}
                <div class="form-group">
                    {{ Form::label('event_group_id', trans('labels.backend.events-subcategory.validation.event_group_id'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('event_group_id', $getEventGroupsList, null, ["class" => "form-control box-size", "data-column" => 2, "placeholder" => trans('labels.backend.events-subcategory.validation.event_group_id'), 'required' => 'required']) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                <input type="hidden" name="event_group_id" id="hdn-eventgroupid" value="" />
                {{-- Including Form blade file --}}
                <div class="form-group">
                    <div class="edit-form-btn">
                    {{ link_to_route('admin.eventsubcategories.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    <!-- <a class="btn btn-success btn-md" id="events-subcategory-main-form-next" href="javascript:void(0);" title="events-subcategory-main-form-next">Submit</a> -->
                    {{ Form::submit(trans('labels.backend.events-subcategory.buttons.create'), ['class' => 'btn btn-success btn-md']) }}
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
        });

        jQuery(document).on('change', '#event_group_id', function(){
            $('#hdn-eventgroupid').val($(this).val());
        });

        jQuery(document).on('change', '#category_id', function(){
            var catID = $(this).val();

            if (catID == 1) {
                $('#event_group_id').val(1);
                $('#hdn-eventgroupid').val(1);
                $('#event_group_id').addClass('field_disabled').attr('readonly', 'readonly');
                $('#event_group_id option').attr('disabled', 'disabled');
            } else if (catID == 2) {
                $('#event_group_id').val(4);
                $('#hdn-eventgroupid').val(4);
                $('#event_group_id').addClass('field_disabled').attr('readonly', 'readonly');
                $('#event_group_id option').attr('disabled', 'disabled');
            } else {
                $('#event_group_id').val('');
                $('#hdn-eventgroupid').val('');
                $('#event_group_id').removeClass('field_disabled').removeAttr('readonly', 'readonly');
                $('#event_group_id option').removeAttr('disabled', 'disabled');
            }
        });
    </script>
@endsection
