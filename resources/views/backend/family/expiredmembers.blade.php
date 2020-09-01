@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.family.newmanagement') . ' | ' . trans('labels.backend.family.memberexpired'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.family.memberexpired') }}
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.family.storenewrelation', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-new-family']) }}
        <div class="box box-info">
            <div class="box-body">
                <div class="loading" style="display:none;">
                    <div class="loader"></div>
                </div>
                {{-- Death Date --}}
                    <div class="form-group aadhar-box">
                        {{ Form::label('date_of_death', trans('labels.backend.family.memberexpired'), ['class' => 'col-lg-2 control-label']) }}
                        <div class="col-lg-10">
                            {{ Form::date('date_of_death', date("Y-m-d"), ['class' => 'form-control box-size', 'id' => 'date-input']) }}
                        </div><!--col-lg-10-->
                    </div><!--form control-->

                    {{-- Including Form blade file --}}
                    <div class="form-group">
                        <div class="update-new-btn">
                        <!-- <a class="btn btn-success btn-md" id="family-main-form-next" href="javascript:void(0);" title="family-main-form-next">Submit</a> -->
                        {{ Form::submit(trans('labels.backend.family.buttons.update'), ['class' => 'btn btn-success btn-md']) }}
                        <div class="clearfix"></div>
                    </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    <div aria-hidden="true" aria-labelledby="family-main-member-confirmation" class="modal fade " id="family-main-member-confirmation" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="section-heading">
                        <h3>વિગત ચકાસો</h3>
                    </div>
                    <h5 class="modal-title">
                    </h5>
                    <br/>
                    <div class="modal-footer center-aligned">
                        <button type="button" data-dismiss="modal" class="btn btn-info btn-small">Modify</button>
                        {{ Form::submit('Contiue without Offer', ['class' => 'btn btn-warning btn-small', 'id' => 'multibenef_corporate_submit_btn']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('after-scripts')
    <script type="text/javascript">

        jQuery(document).ready(function() {
            $('.loading').hide();
            SMJ.Family.init();
            SMJ.Utility.Datepicker.init();
        });
    </script>
@endsection
