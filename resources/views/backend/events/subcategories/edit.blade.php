@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.events-subcategory.newmanagement') . ' | ' . trans('labels.backend.events-subcategory.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.events-subcategory.edit') }}
    </h1>
@endsection

@section('content')
    {{ Form::model($subcategory, ['route' => ['admin.eventsubcategories.update', $subcategory], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-family', 'files' => true]) }}
        <div class="box box-info">
            <div class="box-body">
                <div class="loading" style="display:none;">
                    <div class="loader"></div>
                </div>
                {{-- Sub Category Name --}}
                <div class="form-group">
                    {{ Form::label('sub_category_name', trans('labels.backend.events-subcategory.validation.sub_category_name'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('sub_category_name', (isset($subcategory->sub_category_name) ? $subcategory->sub_category_name : '' ), ['class' => 'form-control box-size', 'pattern' => '^[a-zA-Z0-9-_ ]*$', 'title' => 'Please enter proper name', 'placeholder' => trans('labels.backend.events-subcategory.validation.sub_category_nameholder'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Category Id --}}
                <div class="form-group">
                    {{ Form::label('category_id', trans('labels.backend.events-subcategory.validation.category_id'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('category_id', $mainEventCategoriesList, (isset($subcategory->category_id) ? $subcategory->category_id : '' ), ["class" => "form-control box-size", "placeholder" => trans('labels.backend.events-subcategory.validation.category_idholder'), 'required' => 'required']) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Event Group --}}
                <div class="form-group">
                    {{ Form::label('event_group_id', trans('labels.backend.events-subcategory.validation.event_group_id'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('event_group_id', $getEventGroupsList, (isset($subcategory->event_group_id) ? $subcategory->event_group_id : '' ), ["class" => "form-control box-size", "placeholder" => trans('labels.backend.events-subcategory.validation.event_group_id'), 'required' => 'required' ]) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Including Form blade file --}}
                <div class="form-group">
                    <div class="edit-form-btn">
                    {{ link_to_route('admin.eventsubcategories.index', trans('buttons.general.cancel'), ['class' => 'btn btn-danger btn-md']) }}
                    <!-- <a class="btn btn-success btn-md" id="family-main-form-next" href="javascript:void(0);" title="family-main-form-next">Submit</a> -->
                    {{ Form::submit(trans('labels.backend.family.buttons.update'), ['class' => 'btn btn-success btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection

@section('after-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            SMJ.events-subcategory.init();
            SMJ.Utility.Datepicker.init();
        });
    </script>
@endsection