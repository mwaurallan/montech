@if(Sentinel::hasAccess('communication.delete'))
    <a href="{{ url('communication/sms/'.$id.'/delete') }}"
       class="delete"><i
                class="fa fa-trash"></i> </a>
@endif
