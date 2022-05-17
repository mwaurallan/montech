{!! Form::open(['route' => ['mpesaPayments.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if(Sentinel::hasAccess('mpesaPayments.view'))
        <a href="{{ route('mpesaPayments.show', $id) }}" class='btn btn-default btn-xs'>
            show
        </a>
    @endif
    @if(Sentinel::hasAccess('mpesaPayments.update'))
        <a href="{{ route('mpesaPayments.edit', $id) }}" class='btn btn-default btn-xs'>
            edit
        </a>
    @endif
     @if(Sentinel::hasAccess('mpesaPayments.delete'))
        {!! Form::button('delete', [
            'type' => 'submit',
            'class' => 'btn btn-danger btn-xs',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}
    @endif
</div>
{!! Form::close() !!}

