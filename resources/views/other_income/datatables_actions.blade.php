<ul class="icons-list">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-menu9"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
            @if(Sentinel::hasAccess('other_income.update'))
                <li><a href="{{ url('other_income/'.$id.'/edit') }}"><i
                            class="fa fa-edit"></i> {{ trans('general.edit') }} </a>
                </li>
            @endif
            @if(Sentinel::hasAccess('other_income.delete'))
                <li><a href="{{ url('other_income/'.$id.'/delete') }}"
                       class="delete"><i
                            class="fa fa-trash"></i> {{ trans('general.delete') }}
                    </a>
                </li>
            @endif
        </ul>
    </li>
</ul>
