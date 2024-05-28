@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar gasto {{$expense->title}}</h3>
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
                           
                            {!! Form::model($expense,['route' => ['expenses.update',$expense], 'method' => 'PUT']) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="title">Nombre del gasto</label>
                                            {!! Form::text('title', $expense->title, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                   
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="title">Descripcion</label>
                                            {!! Form::text('description', $expense->description, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                   
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="total">Monto</label>
                                            {!! Form::number('total', $expense->total, array('class' => 'form-control', 'step' =>'any', 'placeholder' => '$')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="category_of_expense_id">Tipo de Gasto</label>
                                            {!! Form::select('category_of_expense_id',$categoryExpenses,$expense->category_of_expense_id, array('class' => 'form-control', 
                                            'style'=>'  background-color: rgb(233, 186, 186);', 'required')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="office_id">Sucursal</label>
                                            {!! Form::select('office_id', $offices, $expense->office->id, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                   
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button class="btn btn-warning form-control" type="submit">Actualizar</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

