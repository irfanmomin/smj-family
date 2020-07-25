<!--Action Button-->
@if (access()->allow('view-all-members-list') == true)
    <div class="btn-group">
        {{ Form::open(['route' => 'admin.family.get', 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'family_advance_search','autocomplete'=>'off']) }}
            {!! Form::select('verifyfilter', ['all' => 'All', 'unverified' => 'Non Verified', 'verified' => 'Verified'], null, ["class" => "form-control box-size", 'id' => 'verify-select',"data-column" => 4, 'required' => 'required']) !!}
            {{ Form::submit('Search', ['class' => 'btn btn-primary btn-md hidden']) }}
        {{ Form::close() }}
    </div>
@endif
@if (access()->allow('admin') == true)
    <div class="btn-group">
        <button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">@lang('menus.backend.access.export')
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li style="display:none;" id="copyButton"><a href="#"><i class="fa fa-clone"></i> @lang('menus.backend.access.copy')</a></li>
            <li id="csvButton"><a href="#"><i class="fa fa-file-text-o"></i> CSV</a></li>
            <li style="display:none;" id="excelButton"><a href="#"><i class="fa fa-file-excel-o"></i> Excel</a></li>
            <li id="pdfButton"><a href="#"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
            <li id="printButton"><a href="#"><i class="fa fa-print"></i> @lang('menus.backend.access.print')</a></li>
        </ul>
    </div>
@endif
<div class="btn-group">
    <a class="btn btn-success btn-md" href="{{route('admin.family.create')}}">
        <i class="fa fa-user-plus"></i> {{trans('menus.backend.family.create')}}
    </a>

    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route( 'admin.family.index' ) }}">
                <i class="fa fa-list-ul"></i> {{ trans( 'menus.backend.family.all' ) }}
            </a>
        </li>
        <li>
            <a href="{{route('admin.family.create')}}">
                <i class="fa fa-plus"></i> {{trans('menus.backend.family.create')}}
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"></div>
