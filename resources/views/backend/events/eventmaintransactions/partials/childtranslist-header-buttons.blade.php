<!--Action Button-->
<div class="btn-group">
    <a class="btn btn-success btn-md" href="{{route('admin.maintransactions.create')}}">
        <i class="fa fa-user-plus"></i> {{trans('menus.backend.childtranslist.create')}}
    </a>

    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route( 'admin.maintransactions.index' ) }}">
                <i class="fa fa-list-ul"></i> {{ trans( 'menus.backend.childtranslist.all' ) }}
            </a>
        </li>
        <li>
            <a href="{{route('admin.maintransactions.create')}}">
                <i class="fa fa-plus"></i> {{trans('menus.backend.childtranslist.create')}}
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"></div>
