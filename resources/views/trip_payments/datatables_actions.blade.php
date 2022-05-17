{!! Form::open(['route' => ['tripPayments.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if(Sentinel::hasAccess('tripPayments.view'))
        <a href="{{ route('tripPayments.show', $id) }}" class='btn btn-default btn-xs'>
            show
        </a>
    @endif
    @if(Sentinel::hasAccess('tripPayments.update'))
        <a href="{{ route('tripPayments.edit', $id) }}" class='btn btn-default btn-xs'>
            edit
        </a>
    @endif
     @if(Sentinel::hasAccess('tripPayments.delete'))
        {!! Form::button('delete', [
            'type' => 'submit',
            'class' => 'btn btn-danger btn-xs',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}
    @endif
</div>
{!! Form::close() !!}
