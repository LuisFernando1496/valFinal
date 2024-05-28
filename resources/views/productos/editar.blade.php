@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar de producto</h3>
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
                            {!! Form::model($producto, ['method'=>'PUT','route'=>['productos.update',$producto->id]]) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="bar_code">Codigo de Barras</label>
                                            {!! Form::text('bar_code', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="description">Descripcion</label>
                                            {!! Form::text('description', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="mark">Marca</label>
                                            {!! Form::text('mark', null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            {!! Form::number('stock', $producto->vendor[0]->stock, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="vendor_id">Proveedor</label>
                                            {!! Form::select('vendor_id', $vendors, $vendor->id, array('class' => 'form-control', 'id' => 'vendors')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="category_id">Categoria</label>
                                            {!! Form::select('category_id', [], $producto->category_id, array('class' => 'form-control', 'id' => 'categorias')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button class="btn btn-primary" type="submit">Actualizar</button>
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

            var id = $('#vendors').children("option:selected").val();
            $.get("/getCategorias/"+id,function (data){
                console.log(data);
                $('#categorias').empty();
                $.each(data, function(key, value){
                    console.log(key);
                    console.log(value);
                    //Use the Option() constructor to create a new HTMLOptionElement.
                    var option = new Option(key, value);
                    //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                    $(option).html(value);
                    console.log(option);
                    //Append the option to our Select element.
                    $("#categorias").append("<option value='"+key+"'>"+value+"</option>");
                });
            });

            $('#vendors').on('change', function(){
                var id = $(this).children("option:selected").val();
                $.get("/getCategorias/"+id,function (data){
                    console.log(data);
                    $('#categorias').empty();
                    $.each(data, function(key, value){
                        console.log(key);
                        console.log(value);
                        //Use the Option() constructor to create a new HTMLOptionElement.
                        var option = new Option(key, value);
                        //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                        $(option).html(value);
                        console.log(option);
                        //Append the option to our Select element.
                        $("#categorias").append("<option value='"+key+"'>"+value+"</option>");
                    });
                });
            });
        });
    </script>
@endsection

