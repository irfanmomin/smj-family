<!--Action Button-->
<div class="btn-group">
    <a class="btn btn-success btn-md" href="{{route('admin.eventsubcategories.create')}}">
        <i class="fa fa-user-plus"></i> {{trans('menus.backend.events-categories.create')}}
    </a>

    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route( 'admin.eventsubcategories.index' ) }}">
                <i class="fa fa-list-ul"></i> {{ trans( 'menus.backend.events-categories.all' ) }}
            </a>
        </li>
        <li>
            <a href="{{route('admin.eventsubcategories.create')}}">
                <i class="fa fa-plus"></i> {{trans('menus.backend.events-categories.create')}}
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"></div>
