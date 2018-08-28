@extends('layouts.principal')

@section('content')
    <form id="formAlmacen">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="Sede_id" name="Sede_id" >
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Crear Almacen</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nombre</label>
                                <input id="Nombre" name="Nombre" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Ubicación</label>
                                <input id="Ubicacion" name="Ubicacion" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="GuardarAlmacen()" type="button" class="btn btn-success">Crear Almacen</button>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>

@endsection
