@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.family.newmanagement') . ' | ' . trans('labels.backend.family.editfamily'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.family.editfamily') }}
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.family.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-new-family']) }}
        <div class="box box-info">
            <div class="box-body">
                <div class="panel panel-info" id="accordion">
                    <div class="panel-heading panelHeader" data-toggle="collapse" data-target="#body" style="cursor:pointer;">
                        @php $childExists = false; $totalChild = 1; @endphp
                        @if (!is_null($childMembersArray) && count($childMembersArray))
                            @php $totalChild = count($childMembersArray)+1;
                            $childExists = true;
                             @endphp
                        @endif
                        <div class="">
                            <h4>{{ $mainMemberArray['firstname'].' '.$mainMemberArray['lastname'].' '.$mainMemberArray['surname'] . ' ('. $totalChild.')' }}</h4><span style="float: right; top: -28px;" class="glyphicon glyphicon-plus"></span>
                        </div>
                    </div>
                    <div class="panel-body collapse" style="overflow-x: scroll;" id="body">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>{{ trans('labels.backend.family.memberslist.action') }}</th>
                                <th>#</th>
                                <th>{{ trans('labels.backend.family.memberslist.name') }}</th>
                                <th>{{ trans('labels.backend.family.memberslist.dob') }}</th>
                                <th>{{ trans('labels.backend.family.memberslist.relation') }}</th>
                                <th>{{ trans('labels.backend.family.memberslist.gender') }}</th>
                                <th>{{ trans('labels.backend.family.memberslist.mobile') }}</th>
                                <th>{{ trans('labels.backend.family.memberslist.aadhar_id') }}</th>
                                <th>{{ trans('labels.backend.family.memberslist.election_id') }}</th>
                                <th>{{ trans('labels.backend.family.memberslist.area') }}</th>
                                <th>{{ trans('labels.backend.family.memberslist.city') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: wheat;">
                                    <td>
                                        <a href="{{ route('admin.family.edit', $mainMemberArray['id']) }}">
                                            <img width="18" src="{{url('/')}}/img/edit.png" />
                                        </a>
                                        &nbsp;
                                        <a href="{{ route('admin.family.deletefullfamily', $mainMemberArray['id']) }}" onclick="return confirm('Are you sure, You want to delete FULL Family?')" data-method="delete" >
                                            <img width="18" src="{{url('/')}}/img/delete.png" />
                                        </a>
                                        &nbsp;
                                        @if (access()->allow('view-all-members-list') == true && $mainMemberArray['is_verified'] == 0)
                                            <a href="{{ route('admin.family.verifymember', $mainMemberArray['id']) }}" onclick="return confirm('બધી વિગત બરાબર છે?')">
                                                <img width="18" src="{{url('/')}}/img/verify.png" />
                                            </a>
                                        @elseif (access()->allow('view-all-members-list') == true && $mainMemberArray['is_verified'] == 1)
                                            <a href="{{ route('admin.family.unverifymember', $mainMemberArray['id']) }}">
                                                <img width="22" src="{{url('/')}}/img/unverify.png" />
                                            </a>
                                        @endif
                                    </td>
                                    <td>1</td>
                                    <td>{{ $mainMemberArray['firstname'].' '.$mainMemberArray['lastname'] }}</td>
                                    <td>
                                        @php
                                            $now = date('Y-m-d');
                                            $dob = new DateTime($mainMemberArray['dob']);
                                            $now = new DateTime($now);
                                            $interval = $now->diff($dob);
                                        @endphp
                                        {{ date('d M Y', strtotime($mainMemberArray['dob'])).' ('.$interval->format('%yY %mM').')' }}

                                    </td>
                                    <td>{{ config('smj.relation_label.'.$mainMemberArray['relation']) }}</td>
                                    <td>{{ ($mainMemberArray['gender'] == 'M' ? 'પુરુષ' : 'સ્ત્રી') }}</td>
                                    <td>{{ $mainMemberArray['mobile'] }}</td>
                                    <td>{{ $mainMemberArray['aadhar_id'] }}</td>
                                    <td>{{ $mainMemberArray['election_id'] }}</td>
                                    <td>{{ $mainMemberArray['area'] }}</td>
                                    <td>{{ $mainMemberArray['city'] }}</td>
                                </tr>
                                @if ($childExists == true)
                                    @php $count = 1; @endphp
                                    @foreach ($childMembersArray as $member)
                                        @php $count++; @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.family.edit', $member->id) }}">
                                                    <img width="18" src="{{url('/')}}/img/edit.png" />
                                                </a>
                                                &nbsp;
                                                <a href="{{ route('admin.family.destroy', $member) }}" class="" data-method="delete"
                                                    data-trans-button-cancel="{{ trans('buttons.general.cancel') }}"
                                                    data-trans-button-confirm="{{ trans('buttons.general.crud.delete') }}"
                                                    data-trans-title="{{ trans('strings.backend.general.are_you_sure') }}">
                                                    <img width="18" src="{{url('/')}}/img/delete.png" />
                                                </a>
                                                &nbsp;
                                                @if (access()->allow('view-all-members-list') == true && $member->is_verified == 0)
                                                    <a href="{{ route('admin.family.verifymember', $member->id) }}" onclick="return confirm('બધી વિગત બરાબર છે?')">
                                                        <img width="18" src="{{url('/')}}/img/verify.png" />
                                                    </a>
                                                @elseif (access()->allow('view-all-members-list') == true && $member->is_verified == 1)
                                                    <a href="{{ route('admin.family.unverifymember', $member->id) }}">
                                                        <img width="22" src="{{url('/')}}/img/unverify.png" />
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $count }}</td>
                                            <td>{{ $member->firstname.' '.$member->lastname }}</td>
                                            <td>
                                                @php
                                                    $now = date('Y-m-d');
                                                    $dob = new DateTime($member->dob);
                                                    $now = new DateTime($now);
                                                    $interval = $now->diff($dob);
                                                @endphp
                                                {{ date('d M Y', strtotime($member->dob)).' ('.$interval->format('%yY %mM').')' }}

                                            </td>
                                            <td>{{ config('smj.relation_label.'.$member->relation) }}</td>
                                            <td>{{ ($member->gender == 'M' ? 'પુરુષ' : 'સ્ત્રી') }}</td>
                                            <td>{{ $member->mobile }}</td>
                                            <td>{{ $member->aadhar_id }}</td>
                                            <td>{{ $member->election_id }}</td>
                                            <td>{{ $member->area }}</td>
                                            <td>{{ $member->city }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><h5><strong>{{ trans('labels.backend.family.title.newmember') }}</strong></h5></div>
                    <div class="panel-body">
                        <!-- Only if this is member of the Family -->
                        {{-- Relation Details --}}
                        <div class="form-group">
                            {{ Form::label('relation', trans('labels.backend.family.validationedit.relation'), ['class' => 'col-lg-2 control-label required']) }}
                            <div class="col-lg-10">
                                {!! Form::select('relation', config('smj.relation_field'), (isset($mainMemberArray->relation) ? $mainMemberArray->relation : '' ), ["class" => "form-control box-size", "placeholder" => trans('labels.backend.family.validationedit.relationholder'), 'required' => 'required']) !!}
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                        {{-- New Member First Name --}}
                        <div class="form-group">
                            {{ Form::label('firstname', trans('labels.backend.family.validationedit.firstname'), ['class' => 'col-lg-2 control-label required']) }}
                            <div class="col-lg-10">
                                {{ Form::text('firstname', (isset($mainMemberArray->firstname) ? $mainMemberArray->firstname : '' ), ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.family.validationedit.firstnameholder'), 'required' => 'required', 'onkeyup'=> "this.value = this.value.toUpperCase();"]) }}
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                        {{-- New Member Last Name --}}
                        <div class="form-group">
                            {{ Form::label('lastname', trans('labels.backend.family.validationedit.lastname'), ['class' => 'col-lg-2 control-label required']) }}
                            <div class="col-lg-10">
                                {{ Form::text('lastname', (isset($mainMemberArray->lastname) ? $mainMemberArray->lastname : '' ), ['class' => 'form-control box-size', 'placeholder' => trans('labels.backend.family.validationedit.lastnameholder'), 'required' => 'required', 'onkeyup' => "this.value = this.value.toUpperCase();"]) }}
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                        {{-- Main Member Gender --}}
                        <div class="form-group">
                            {{ Form::label('gender', trans('labels.backend.family.validation.gender'), ['class' => 'col-lg-2 control-label required']) }}
                            <div class="col-lg-10">
                                    {{ Form::radio('gender', 'M', true,['required' => 'required', 'class'=>'flat-blue','id' => 'male']) }} {{ trans('labels.backend.family.validation.malegender') }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::radio('gender', 'F', false,['required' => 'required', 'class'=>'flat-blue','id' => 'female']) }} {{ trans('labels.backend.family.validation.femalegender') }}
                            </div>
                        </div>
                        {{-- New Member Mobile Number --}}
                        <div class="form-group">
                            {{ Form::label('mobile', trans('labels.backend.family.validationedit.mobile'), ['class' => 'col-lg-2 control-label required']) }}
                            <div class="col-lg-10">
                                {{ Form::text('mobile', (isset($mainMemberArray['mobile']) ? $mainMemberArray['mobile'] : '' ), ['class' => 'form-control box-size', 'title' => 'Only 10 digit Mobile Number', 'pattern' => '^\s*-?[0-9]{10}\s*$', 'placeholder' => trans('labels.backend.family.validationedit.mobileholder'), 'maxlength' => '10', 'required' => 'required']) }}
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                        {{-- New Member DOB --}}
                        <div class="form-group">
                            {{ Form::label('dob', trans('labels.backend.family.validationedit.dob'), ['class' => 'col-lg-2 control-label required']) }}
                            <div class="col-lg-10">
                                <div class="dateclass">
                                    <div class="date-block">
                                        <div class="input-group input-group-custom border-none">
                                            <input class="form-control eremitdatepicker" value="{{ isset($mainMemberArray->dob) ? date('d-m-Y', strtotime($mainMemberArray->dob)) : '' }}" name="dob" id="dob" placeholder="DOB (dd-mm-yyyy)" type="text">
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
                                {{ Form::text('election_id', null, ['class' => 'form-control box-size election_id_field', 'title' => 'Only Number is Allowed', 'maxlength' => '25']) }}
                            </div><!--col-lg-10-->
                        </div><!--form control-->
                        <input type="hidden" name="surname" value="{{ $mainMemberArray['surname'] }}" />
                        <input type="hidden" name="area" value="{{ $mainMemberArray['area'] }}" />
                        <input type="hidden" name="city" value="{{ $mainMemberArray['city'] }}" />
                        <input type="hidden" name="is_main" value="0" />
                        <input type="hidden" name="family_id" value="{{ $mainMemberArray['id'] }}" />
                        {{-- Including Form blade file --}}
                        <div class="form-group">
                            <div class="edit-form-btn">
                            {{ link_to_route('admin.family.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                            <!-- <a class="btn btn-success btn-md" id="family-main-form-next" href="javascript:void(0);" title="family-main-form-next">Submit</a> -->
                            {{ Form::submit(trans('labels.backend.family.buttons.create'), ['class' => 'btn btn-success btn-md']) }}
                            <div class="clearfix"></div>
                        </div>
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
            SMJ.Family.init();
            SMJ.Utility.Datepicker.init();
            $('.election-box').hide();
            $(document).on('change', '#city', function() {
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

                        return true;
                    },
                });
            });
        });
    </script>
@endsection
