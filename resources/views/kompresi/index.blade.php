@extends('layouts.app')

@section('content')
<div class="container">
    {!! Form::open(['route' => 'kompresi-audio.store', 'method' => 'post', 'autocomplete' => 'false','enctype'=>'multipart/form-data']) !!}
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card" style="background-color:#000000;height:400px">
               
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div class="">
                        {!! Form::label('audio', 'Pilih Audio',['class'=>'text-light']) !!}
                        {!! Form::file('audio', $errors->has('audio') ? ['class'=>'form-control is-invalid','accept'=>"audio/*"] : ['class'=>'form-control','accept'=>"audio/*"]) !!}
                        {!! $errors->first('audio', '<p class="help-block invalid-feedback">:message</p>') !!}
                    </div>
                </div>
                
                
            </div>
        </div>
        <div class="col-6">
            <div class="card" style="background-color:#503D98;height:400px">
                <div class="card-body">
                    @if (session('download'))
                    <a class="btn btn-light w-100" href="{{session('download')[0]}}">

                    
                    <div class="d-flex justify-content-between">
                        <div class="col-8">
                            <h4 class="text-dark">
                                {{session('download')[1]}}
                            </h4> 
                        </div>
                        <div class="col-4">
                            <h4 class="text-dark">
                                Download
                            </h4>
                        </div>
                        
                    </div>
                </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <div class="row  justify-content-center mt-4">
        <div class="col-4 d-flex justify-content-center">
            {!! Form::submit('Kompresi Sekarang', ['class' => 'btn btn-primary btn-block', 'id' => 'save']) !!}
        </div>
        
    </div>
    
    {!! Form::close() !!}
</div>
@endsection
