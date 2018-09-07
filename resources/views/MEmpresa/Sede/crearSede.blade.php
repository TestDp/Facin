@extends('layouts.principal')

@section('content')
    <form id="formSede">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Crear nueva sede</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nombre</label>
                                <input id="Nombre" name="Nombre" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorNombre"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Dirección</label>
                                <input id="Direccion" name="Direccion" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorDireccion"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Teléfono</label>
                                <input id="Telefono" name="Telefono" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorTelefono"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="GuardarSede()" type="button" class="btn btn-success">Crear Sede</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

@endsection
