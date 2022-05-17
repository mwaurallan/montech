{!! Form::open(['route' => ['invoices.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if(Sentinel::hasAccess('invoices.view'))
        <a href="{{ route('invoices.show', $id) }}" class='btn btn-default btn-xs'>
            show
        </a>
    @endif
{{--    @if(Sentinel::hasAccess('invoices.update'))--}}
{{--        <a href="{{ route('invoices.edit', $id) }}" class='btn btn-default btn-xs'>--}}
{{--            edit--}}
{{--        </a>--}}
{{--    @endif--}}
{{--     @if(Sentinel::hasAccess('invoices.delete'))--}}
{{--        {!! Form::button('delete', [--}}
{{--            'type' => 'submit',--}}
{{--            'class' => 'btn btn-danger btn-xs',--}}
{{--            'onclick' => "return confirm('Are you sure?')"--}}
{{--        ]) !!}--}}
{{--    @endif--}}
</div>
{!! Form::close() !!}

