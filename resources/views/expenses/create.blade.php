@extends('layouts.app')

@section('content')
<style>
    select,
option {
    color: white;
        background-color: rgb(233, 186, 186);
        
}

</style>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear gastos</h3>
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
                           
                            {!! Form::open(array('route' => 'expenses.store', 'method' => 'POST')) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="title">Nombre del gasto</label>
                                            {!! Form::text('title', NULL, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                   
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="title">Descripcion</label>
                                            {!! Form::text('description', NULL, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                   
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="total">Monto</label>
                                            {!! Form::number('total', NULL, array('class' => 'form-control', 'step' =>'any', 'placeholder' => '$')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="category_of_expense_id">Tipo de Gasto</label>
                                            {!! Form::select('category_of_expense_id',$categoryExpenses, [], array('id'=>'expense','class' => 'form-control', 
                                            'style'=>'  background-color: rgb(233, 186, 186);', 'required')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" style="display: none" id="employee_id">
                                        <div class="form-group">
                                            <label for="user_empleado_id">Empleado</label>
                                            {!! Form::select('user_empleado_id',$employees, [], array('class' => 'form-control', 'id'=>'selected_employee',
                                             )) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" style="display: none" id="owner_id">
                                        <div class="form-group">
                                            <label for="owner_id">Dueño</label>
                                            {!! Form::select('owner_id',$owners, [], array('class' => 'form-control', 'id'=>'selected_owner',
                                             )) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="office_id">Sucursal</label>
                                            {!! Form::select('office_id', $offices, [], array('class' => 'form-control')) !!}
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
      $('#expense').change(function(){
         if($(this).val() == 7){
            $('#employee_id').show();
            $('#owner_id').hide();
            $('#selected_owner').empty();
        }else if($(this).val() == 6){
            $('#employee_id').hide();
            $('#selected_employee').val('');
            $('#owner_id').show();
        }else{
            $('#employee_id').hide();
            $('#owner_id').hide();
            $('#selected_employee').val('');
            $('#selected_owner').val('');
        }
      
        });
    </script>
@endsection

