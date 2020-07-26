@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.family.newmanagement') . ' | ' . trans('labels.backend.family.new'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.family.new') }}
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.family.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-new-family']) }}
        <div class="box box-info">
            <div class="box-body">
                <div class="loading" style="display:none;">
                    <div class="loader"></div>
                </div>
                {{-- New Member First Name --}}
                <div class="form-group">
                    {{ Form::label('firstname', trans('labels.backend.family.validation.firstname'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('firstname', null, ['class' => 'form-control box-size', 'pattern' => '^[a-zA-Z ]*$', 'title' => 'Only NAME is allowed', 'placeholder' => trans('labels.backend.family.validation.firstnameholder'), 'required' => 'required', 'onkeyup'=> "this.value = this.value.toUpperCase();"]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- New Member Last Name --}}
                <div class="form-group">
                    {{ Form::label('lastname', trans('labels.backend.family.validation.lastname'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('lastname', null, ['class' => 'form-control box-size', 'pattern' => '^[a-zA-Z ]*$', 'title' => 'Only NAME is allowed', 'placeholder' => trans('labels.backend.family.validation.lastnameholder'), 'required' => 'required', 'onkeyup' => "this.value = this.value.toUpperCase();"]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Main Member Surname --}}
                <div class="form-group">
                    {{ Form::label('surname', trans('labels.backend.family.validation.surname'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('surname', config('smj.surname'), null, ["class" => "form-control box-size", "data-column" => 2, "placeholder" => trans('labels.backend.family.validation.surnameholder'), 'required' => 'required']) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Main Member Gender --}}
                <div class="form-group">
                    {{ Form::label('gender', trans('labels.backend.family.validation.gender'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                            {{ Form::radio('gender', 'M',true,['required' => 'required', 'class'=>'flat-blue','id' => 'male']) }} {{ trans('labels.backend.family.validation.malegender') }}
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ Form::radio('gender', 'F',false,['required' => 'required', 'class'=>'flat-blue','id' => 'female']) }} {{ trans('labels.backend.family.validation.femalegender') }}
                    </div>
                </div>
                {{-- New Member Mobile Number --}}
                <div class="form-group">
                    {{ Form::label('mobile', trans('labels.backend.family.validation.mobile'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('mobile', null, ['class' => 'form-control box-size', 'title' => 'Only 10 digit Mobile Number', 'pattern' => '^\s*-?[0-9]{10}\s*$', 'placeholder' => trans('labels.backend.family.validation.mobileholder'), 'maxlength' => '10', 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- New Member DOB --}}
                <div class="form-group">
                    {{ Form::label('dob', trans('labels.backend.family.validation.dob'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        <div class="dateclass">
                            <div class="date-block">
                                <div class="input-group input-group-custom border-none">
                                    <input class="form-control eremitdatepicker" name="dob" id="dob" placeholder="DOB (dd-mm-yyyy)" type="text">
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--form control-->
                {{-- Main Member Document Type --}}
                <div class="form-group">
                    {{ Form::label('doc_type', trans('labels.backend.family.validation.doc_type'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                            {{ Form::radio('doc_type', 'aadhar',true,['required' => 'required', 'class'=>'flat-blue','id' => 'aadhar']) }} {{ trans('labels.backend.family.validation.radioaadhar') }}
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ Form::radio('doc_type', 'election',false,['required' => 'required', 'class'=>'flat-blue','id' => 'election']) }} {{ trans('labels.backend.family.validation.radioelection') }}
                    </div>
                </div>
                {{-- New Member Aadhar Number --}}
                <div class="form-group aadhar-box">
                    {{ Form::label('aadhar_id', trans('labels.backend.family.validation.aadhar_id'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::text('aadhar_id', null, ['class' => 'form-control box-size aadhar_id_field', 'id' => 'aadhar-input', 'title' => 'Only Number is Allowed', 'pattern' => '^\s*-?[0-9-]{14}\s*$', 'placeholder' => trans('labels.backend.family.validation.aadharidph'), 'maxlength' => '14']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- New Member Election Number --}}
                <div class="form-group election-box">
                    {{ Form::label('election_id', trans('labels.backend.family.validation.election_id'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::text('election_id', null, ['class' => 'form-control box-size election_id_field', 'title' => 'Only Number is Allowed', 'maxlength' => '255']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- New Member Education --}}
                <div class="form-group">
                    {{ Form::label('education', trans('labels.backend.family.validation.education'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::text('education', null, ['class' => 'form-control box-size']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- New Member Occupation --}}
                <div class="form-group">
                    {{ Form::label('occupation', trans('labels.backend.family.validation.occupation'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::text('occupation', null, ['class' => 'form-control box-size']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                @if (access()->allow('admin') == false)
                    {{-- Main Member City --}}
                    <div class="form-group">
                        {{ Form::label('city', trans('labels.backend.family.validation.city'), ['class' => 'col-lg-2 control-label required']) }}
                        <div class="col-lg-10">
                            {!! Form::select('city', $cityList, null, ["class" => "form-control box-size", "data-column" => 2, 'required' => 'required', 'disabled' => 'disabled']) !!}
                        </div><!--col-lg-10-->
                    </div><!--form control-->
                    <input type="hidden" name="city" value="DHOLKA" />
                @else
                    {{-- Main Member City --}}
                    <div class="form-group">
                        {{ Form::label('city', trans('labels.backend.family.validation.city'), ['class' => 'col-lg-2 control-label required']) }}
                        <div class="col-lg-10">
                            {!! Form::select('city', $cityList, null, ["class" => "form-control box-size", "data-column" => 2, 'required' => 'required']) !!}
                        </div><!--col-lg-10-->
                    </div><!--form control-->
                @endif
                {{-- Main Member Area --}}
                <div class="form-group">
                    {{ Form::label('area', trans('labels.backend.family.validation.area'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('area', $areaList, null, ["class" => "form-control box-size", "data-column" => 2, "placeholder" => trans('labels.backend.family.validation.areaholder'), 'required' => 'required']) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Including Form blade file --}}
                <div class="form-group">
                    <div class="edit-form-btn">
                    {{ link_to_route('admin.family.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    <!-- <a class="btn btn-success btn-md" id="family-main-form-next" href="javascript:void(0);" title="family-main-form-next">Submit</a> -->
                    {{ Form::submit(trans('labels.backend.family.buttons.create'), ['class' => 'btn btn-success btn-md']) }}
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
        document.getElementById('aadhar-input').addEventListener('input', function (e) {
            //e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
            var foo = e.target.value;
            foo = foo.split("-").join("");
            if (foo.length > 0) {
                foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
            }
            e.target.value = foo;
        });
        jQuery(document).ready(function() {
            $('.loading').hide();
            $('.election-box').hide();

            if ($('#aadhar').prop('checked')) {
                $('.election-box').hide();
                $('.aadhar-box').show();
                $('.election-box input').val('');
            } else if ($('#election').prop('checked')) {
                $('.election-box').show();
                $('.aadhar-box').hide();
                $('.aadhar-box input').val('');
            }

            SMJ.Family.init();
            SMJ.Utility.Datepicker.init();

            $(document).on('change', '#city', function() {
                $('.loading').show();
                var cityName = $(this).val();

                $.ajax({
                    url: '{{ route("admin.family.getarealist") }}',
                    type: "get",
                    dataType: "json",
                    sync: true,
                    data: {
                        cityName: cityName
                    },
                    success: function(data) {
                        var output = [];
                        var count = 0;

                        $.each(data, function(k , value) {
                            if (count == 0) {
                                output.push('<option value="">પસંદ કરો</option>');
                            }

                            count++;
                            output.push('<option value="'+ value +'">'+ value +'</option>');
                        });

                        $('#area').html(output.join(''));
                        $('.loading').hide();
                        return true;
                    },
                });
            });
        });
    </script>
@endsection
