{!! Form::open(['route' => ['processedMpesaPayments.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if(Sentinel::hasAccess('processedMpesaPayments.view'))
        <a href="{{ route('processedMpesaPayments.show', $id) }}" class='btn btn-default btn-xs'>
            show
        </a>
    @endif
    @if(Sentinel::hasAccess('processedMpesaPayments.update'))
        <a href="{{ route('processedMpesaPayments.edit', $id) }}" class='btn btn-default btn-xs'>
            edit
        </a>
    @endif
     @if(Sentinel::hasAccess('processedMpesaPayments.delete'))
        {!! Form::button('delete', [
            'type' => 'submit',
            'class' => 'btn btn-danger btn-xs',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}
    @endif
</div>
{!! Form::close() !!}

