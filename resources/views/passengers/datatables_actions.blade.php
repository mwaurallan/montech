{!! Form::open(['route' => ['passengers.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if(Sentinel::hasAccess('passengers.view'))
        <a href="{{ route('passengers.show', $id) }}" class='btn btn-default btn-xs'>
            show
        </a>
    @endif
    @if(Sentinel::hasAccess('passengers.update'))
        <a href="{{ route('passengers.edit', $id) }}" class='btn btn-default btn-xs'>
            edit
        </a>
    @endif
     @if(Sentinel::hasAccess('passengers.delete'))
        {!! Form::button('delete', [
            'type' => 'submit',
            'class' => 'btn btn-danger btn-xs',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}
    @endif
</div>
{!! Form::close() !!}

