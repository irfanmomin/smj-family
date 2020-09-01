@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.family.newmanagement') . ' | ' . trans('labels.backend.family.selectmainmember'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.family.selectmainmember') }}
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
                    {{ Form::label('date_of_death', trans('labels.backend.family.validation.date_of_death'), ['class' => 'col-lg-2 control-label']) }}
                    <div class="col-lg-10">
                        {{ Form::date('date_of_death', date("Y-m-d"), ['class' => 'form-control box-size', 'id' => 'date-input']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Select Main Member --}}
                <div class="form-group">
                    {{ Form::label('mainmemberselect', trans('labels.backend.family.selectmainmember'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        <select name="mainmemberselect" id="choose_main_member_selectbox" class="form-control box-size">
                        @foreach ($childMembersArray as $child)
                            @php
                                $now = date('Y-m-d');
                                $dob = new DateTime($child->dob);
                                $now = new DateTime($now);
                                $interval = $now->diff($dob);
                            @endphp
                            <option value="{{ $child->id }}">{{ $child->firstname.' '.$child->lastname.' ('.$interval->format('%yY %mM').')' }}</option>
                        @endforeach
                        </select>
                        <input type="hidden" name="newmainmember" id="newmainmember" value="" />
                        <input type="hidden" name="expiredmember" id="expiredmember" value="{{ $mainMemberArray->id }}" />
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- New Member Mobile Number --}}
                <div class="form-group">
                    {{ Form::label('mobile', trans('labels.backend.family.validationedit.mobile'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="col-lg-10">
                        {{ Form::text('mobile', (isset($mainMemberArray->mobile) ? $mainMemberArray->mobile : '' ), ['class' => 'form-control box-size', 'title' => 'Only 10 digit Mobile Number', 'pattern' => '^\s*-?[0-9]{10}\s*$', 'placeholder' => trans('labels.backend.family.validationedit.mobileholder'), 'maxlength' => '10', 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
                {{-- Next button --}}
                <div class="form-group">
                    <div class="edit-form-btn">
                    <!-- <a class="btn btn-success btn-md" id="family-main-form-next" href="javascript:void(0);" title="family-main-form-next">Submit</a> -->
                    <a class="btn btn-default btn-md next-btn" href="javascript:void(0)">
                        Next
                    </a>
                    <div class="clearfix"></div>
                </div>
                {{-- New Member First Name --}}

                    <div class="block clearfix  select-after area_hidden">
                        <div class="col-lg-12">
                            <div class="section-heading text-black">
                                Choose Family Members Relation
                            </div>
                            <div class="row members-details-header">
                                <div class="col-xs-8 header-inner">
                                <p class="member-row-text">નામ</p>
                                </div>
                                <div class="col-xs-4 header-inner">
                                <p class="member-row-text">{{ trans('labels.backend.family.validationedit.relationholder') }}</p>
                                </div>
                            </div>
                            @php $i = 1; @endphp
                            @foreach ($childMembersArray as $child)
                                <div class="row benef-detail-row member_{{ $child->id }}">
                                    <div class="col-xs-8 bene-name">
                                        <p class="beneficiary-text"><?php echo $child->firstname.' '.$child->lastname ?></p>
                                    </div>
                                    <div class="col-xs-4 bene-amt">
                                    {!! Form::select('relation_'.$child->id, config('smj.relation_field'), null, ["class" => "form-control", "placeholder" => trans('labels.backend.family.validationedit.relationholder')]) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Including Form blade file --}}
                        <div class="form-group">
                            <div class="update-new-btn">
                            <!-- <a class="btn btn-success btn-md" id="family-main-form-next" href="javascript:void(0);" title="family-main-form-next">Submit</a> -->
                            {{ Form::submit(trans('labels.backend.family.buttons.update'), ['class' => 'btn btn-success btn-md']) }}
                            <div class="clearfix"></div>
                        </div>
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
