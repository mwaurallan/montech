@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sacco
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($sacco, ['route' => ['saccos.update', $sacco->id], 'method' => 'patch']) !!}

                        @include('saccos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection