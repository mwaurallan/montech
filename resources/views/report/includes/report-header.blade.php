<div class="row ">
    <div class="col-sm-3 invoice-col text-center">
        {{--<img src="{{ asset('Logo.bmp') }}"--}}
             {{--class="user-image" alt="logo" style="margin-top: 10px;"/>--}}
{{--        <img src="{{ asset('images.ico') }}" class="user-image" alt="User Image"/>--}}

{{--        <img class="user-image img-responsive" src="{{ (!is_null($logo))?  asset($logo->getUrl('report')) : asset('images.ico') }}" style="object-fit: scale-down;width: 100%" alt="logo">--}}


    </div>
    <!-- /.col -->
    <div class="col-sm-6 invoice-col text-center">
        <h3>RGS SACCO</h3>
           <!-- <h3>{{ \App\Models\Setting::where('setting_key','company_name')->first()->setting_value }}</h3> -->
{{--            <h3>{{ $client->name }}</h3>--}}
{{--            {{ $client->location }}--}}
        {{ \App\Models\Setting::where('setting_key','company_address')->first()->setting_value }}
{{--        <p>Limuru Town</p>--}}
{{--        <p>Kimuchu Complex</p>--}}

{{--            <br>--}}
            <br>
{{--            Phone number: {{ $client->phone_number }}<br>--}}
            Email: {{ \App\Models\Setting::where('setting_key','company_email')->first()->setting_value }}
    </div>
    <!-- /.col -->
    <div class="col-sm-3 invoice-col">

    </div>
    <!-- /.col -->
</div>
