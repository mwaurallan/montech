{!! Form::open(['route' => ['trips.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if(Sentinel::hasAccess('trips.view'))
        <a href="{{ route('trips.show', $id) }}" class='btn btn-default btn-xs'>
            show
        </a>
    @endif
    @if(Sentinel::hasAccess('trips.update'))
        <a href="{{ route('trips.edit', $id) }}" class='btn btn-default btn-xs'>
            edit
        </a>
    @endif
     @if(Sentinel::hasAccess('trips.delete'))
        {!! Form::button('delete', [
            'type' => 'submit',
            'class' => 'btn btn-danger btn-xs',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}
    @endif
</div>
{!! Form::close() !!}
