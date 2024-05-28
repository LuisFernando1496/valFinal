@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta de Almacen</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>Revisa los campos!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            @endif

                            {!! Form::open(array('route' => 'almacenes.store', 'method' => 'POST')) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="title">Nombre</label>
                                            {!! Form::text('title', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="business_id">Negocio</label>
                                            {!! Form::select('business_id', $negocios, [], array('class' => 'form-control', 'id' => 'negocios')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="user_id">Encargado</label>
                                            {!! Form::select('user_id', [], [], array('class' => 'form-control', 'id' => 'usuarios')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            var id = $('#negocios').children("option:selected").val();
            $.get("/getUser/"+id,function (data){
                console.log(data);
                $('#usuarios').empty();
                $.each(data, function(key, value){
                    console.log(key);
                    console.log(value);
                    //Use the Option() constructor to create a new HTMLOptionElement.
                    var option = new Option(key, value);
                    //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                    $(option).html(value);
                    console.log(option);
                    //Append the option to our Select element.
                    $("#usuarios").append("<option value='"+key+"'>"+value+"</option>");
                });
            });
            $('#negocios').on('change', function(){
                var id = $(this).children("option:selected").val();
                $.get("/getUser/"+id,function (data){
                    console.log(data);
                    $('#usuarios').empty();
                    $.each(data, function(key, value){
                        console.log(key);
                        console.log(value);
                        //Use the Option() constructor to create a new HTMLOptionElement.
                        var option = new Option(key, value);
                        //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                        $(option).html(value);
                        console.log(option);
                        //Append the option to our Select element.
                        $("#usuarios").append("<option value='"+key+"'>"+value+"</option>");
                    });
                });
            });
        });
    </script>
@endsection

