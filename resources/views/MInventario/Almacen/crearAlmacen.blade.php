@extends('layouts.principal')

@section('content')
    <form id="formAlmacen">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="Sede_id" name="Sede_id" >
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Crear Almacén</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nombre</label>
                                <input id="Nombre" name="Nombre" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorNombre"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Ubicación</label>
                                <input id="Ubicacion" name="Ubicacion" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorUbicacion"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Sede</label>
                                <select id="Sede_id" name="Sede_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listSedes as $sede)
                                        <option value="{{ $sede->id }}">{{ $sede->Nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorSede_id"></span>
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
