@extends('layouts.principal')

@section('content')
    <form id="formProveedor">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel">
                    <div class="panel-heading"><h3>Crear Proveedor</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nombre</label>
                                <input id="Nombre" name="Nombre" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Apellidos</label>
                                <input id="Apellidos" name="Apellidos" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Nit</label>
                                <input id="Nit" name="Nit" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Identificación</label>
                                <input id="Identificacion" name="Identificacion" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Correco Electrónico</label>
                                <input id="CorreoElectronico" name="CorreoElectronico" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Teléfono</label>
                                <input id="Telefono" name="Telefono" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Celular</label>
                                <input id="Celular" name="Celular" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Terminos de Pago</label>
                                <input id="Terminos_De_Pago" name="Terminos_De_Pago" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Descripción</label>
                                <input id="Descripcion" name="Descripcion" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="GuardarProveedor()" type="button" class="btn btn-success">Crear Proveedor</button>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>

@endsection
