{!! Form::open(['route' => ['vehicles.destroy', $id], 'method' => 'delete']) !!}
 <ul class="icons-list">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-menu9"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">

            @if(Sentinel::hasAccess('vehicles.view'))
                <li><a href="{{ route('vehicles.show', $id) }}"><i
                                class="fa fa-search"></i> {{trans_choice('general.detail',2)}}
                    </a></li>
            @endif
            @if(Sentinel::hasAccess('vehicles.update'))
                <li><a href="{{ route('vehicles.edit', $id) }}"><i
                                class="fa fa-edit"></i> {{ trans('general.edit') }} </a>
                </li>
            @endif
            @if(Sentinel::hasAccess('vehicles.delete'))
                <li><a onclick="if(confirm('Are you sure?')){
                       $(this).closest('form').submit();
                   }"
                          class=""><i
                                   class="fa fa-trash"></i> {{ trans('general.delete') }}
                       </a>
                   </li>

            @endif
        </ul>
    </li>
</ul>
{!! Form::close() !!}
