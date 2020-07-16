@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.family.newmanagement') . ' | ' . trans('labels.backend.family.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.family.edit') }}
    </h1>
@endsection

@section('content')
    {{ Form::model($family, ['route' => ['admin.family.update', $family], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-family', 'files' => true]) }}
        <div class="box box-info">
            <div class="box-body">
                <div class="loading" style="display:none;">
                    <div class="loader"></div>
                </div>
                {{-- New Member First Name --}}
                <div class="form-group">
                    {{ Form::label('firstname', trans('labels.backend.family.validationedit.firstname'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('firstname', (isset($family->firstname) ? $family->firstname : '' ), ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.family.validationedit.firstnameholder'), 'required' => 'required', 'onkeyup'=> "this.value = this.value.toUpperCase();"]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- New Member Last Name --}}
                <div class="form-group">
                    {{ Form::label('lastname', trans('labels.backend.family.validationedit.lastname'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('lastname', (isset($family->lastname) ? $family->lastname : '' ), ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.family.validationedit.lastnameholder'), 'required' => 'required', 'onkeyup' => "this.value = this.value.toUpperCase();"]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Main Member Surname --}}
                <div class="form-group">
                    {{ Form::label('surname', trans('labels.backend.family.validationedit.surname'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('surname', config('smj.surname'), (isset($family->surname) ? $family->surname : '' ), ["class" => "form-control box-size", "placeholder" => trans('labels.backend.family.validationedit.surnameholder'), 'required' => 'required', 'disabled' => ($isMainMember == true) ? false : true ]) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                <!-- Only if this is member of the Family -->
                @if ( $isMainMember == false && !empty($mainMemberArray))
                    {{-- Main Meber Name --}}
                    <div class="form-group">
                        {{ Form::label('lastname', trans('labels.backend.family.validationedit.mainmembername'), ['class' => 'col-lg-2 control-label required']) }}
                        <div class="col-lg-10">
                            {{ Form::text('', $mainMemberArray['firstname'].' '.$mainMemberArray['lastname'].' '.$mainMemberArray['surname'], ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.family.validationedit.lastnameholder'), 'required' => 'required', 'disabled' => 'disabled']) }}
                        </div><!--col-lg-10-->
                    </div><!--form control-->
                    {{-- Relation Details --}}
                    <div class="form-group">
                        {{ Form::label('relation', trans('labels.backend.family.validationedit.relation'), ['class' => 'col-lg-2 control-label required']) }}
                        <div class="col-lg-10">
                            {!! Form::select('relation', config('smj.relation_field'), (isset($family->relation) ? $family->relation : '' ), ["class" => "form-control box-size", "placeholder" => trans('labels.backend.family.validationedit.relationholder'), 'required' => 'required']) !!}
                        </div><!--col-lg-10-->
                    </div><!--form control-->
                @endif
                {{-- Main Member Gender --}}
                <div class="form-group">
                    {{ Form::label('gender', trans('labels.backend.family.validation.gender'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                            {{ Form::radio('gender', 'M',(isset($family->gender) && $family->gender == 'M' ? true : false ),['required' => 'required', 'class'=>'flat-blue','id' => 'male']) }} {{ trans('labels.backend.family.validation.malegender') }}
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ Form::radio('gender', 'F',(isset($family->gender) && $family->gender == 'F' ? true : false ),['required' => 'required', 'class'=>'flat-blue','id' => 'female']) }} {{ trans('labels.backend.family.validation.femalegender') }}
                    </div>
                </div>
                {{-- New Member Mobile Number --}}
                <div class="form-group">
                    {{ Form::label('mobile', trans('labels.backend.family.validationedit.mobile'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('mobile', (isset($family->mobile) ? $family->mobile : '' ), ['class' => 'form-control box-size', 'title' => 'Only 10 digit Mobile Number', 'pattern' => '^\s*-?[0-9]{10}\s*$', 'placeholder' => trans('labels.backend.family.validationedit.mobileholder'), 'maxlength' => '10', 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- New Member DOB --}}
                <div class="form-group">
                    {{ Form::label('dob', trans('labels.backend.family.validationedit.dob'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        <div class="dateclass">
                            <div class="date-block">
                                <div class="input-group input-group-custom border-none">
                                    <input class="form-control eremitdatepicker" value="{{ isset($family->dob) ? date('d-m-Y', strtotime($family->dob)) : '' }}" name="dob" id="dob" placeholder="DOB (dd-mm-yyyy)" type="text">
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--form control-->
                @if (access()->allow('admin') == false)
                    {{-- Main Member City --}}
                    <div class="form-group">
                        {{ Form::label('city', trans('labels.backend.family.validationedit.city'), ['class' => 'col-lg-2 control-label required']) }}
                        <div class="col-lg-10">
                            {!! Form::select('city', $cityList, (isset($family->city) ? $family->city : '' ), ["class" => "form-control box-size", "data-column" => 2, 'required' => 'required', 'disabled' => 'disabled']) !!}
                        </div><!--col-lg-10-->
                    </div><!--form control-->
                    <input type="hidden" name="city" value="DHOLKA" />
                @else
                    {{-- Main Member City --}}
                    <div class="form-group">
                        {{ Form::label('city', trans('labels.backend.family.validationedit.city'), ['class' => 'col-lg-2 control-label required']) }}
                        <div class="col-lg-10">
                            {!! Form::select('city', $cityList, (isset($family->city) ? $family->city : '' ), ["class" => "form-control box-size", "data-column" => 2, 'required' => 'required', 'disabled' => ($isMainMember == true) ? false : true]) !!}
                        </div><!--col-lg-10-->
                    </div><!--form control-->
                @endif
                {{-- Main Member Area --}}
                <div class="form-group">
                    {{ Form::label('area', trans('labels.backend.family.validationedit.area'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {!! Form::select('area', $areaList, (isset($family->area) ? $family->area : '' ), ["class" => "form-control box-size", "data-column" => 2, "placeholder" => trans('labels.backend.family.validationedit.areaholder'), 'required' => 'required', 'disabled' => ($isMainMember == true) ? false : true]) !!}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Including Form blade file --}}
                <div class="form-group">
                    <div class="edit-form-btn">
                    {{ link_to_route('admin.family.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
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
