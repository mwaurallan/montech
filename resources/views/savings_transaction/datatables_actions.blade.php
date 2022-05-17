<ul class="icons-list">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle"
           data-toggle="dropdown">
            <i class="icon-menu9"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
            @if($reversed==0)
                <li>
                    <a href="{{url('saving/savings_transaction/'.$id.'/show')}}"><i
                            class="fa fa-search"></i> {{ trans_choice('general.view',1) }}
                    </a></li>
                <li>
                    <a href="{{url('saving/savings_transaction/'.$id.'/print')}}"
                       target="_blank"><i
                            class="icon-printer"></i> {{ trans_choice('general.print',1) }} {{trans_choice('general.receipt',1)}}
                    </a></li>
                <li>
                    <a href="{{url('saving/savings_transaction/'.$id.'/pdf')}}"
                       target="_blank"><i
                            class="icon-file-pdf"></i> {{ trans_choice('general.pdf',1) }} {{trans_choice('general.receipt',1)}}
                    </a></li>
            @endif
            @if($reversed==0 && $reversible==1)
                <li>
                    <a href="{{url('saving/savings_transaction/'.$id.'/edit')}}"><i
                            class="fa fa-edit"></i> {{ trans('general.edit') }}
                    </a></li>
                <li>
                    <a href="{{url('saving/savings_transaction/'.$id.'/reverse')}}"
                       class="delete"><i
                            class="fa fa-minus-circle"></i> {{ trans('general.reverse') }}
                    </a></li>
            @endif
        </ul>
    </li>
</ul>
