@extends('layouts.principal')

@section('content')
    <form id="formUnidad">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Crear Unidad de medida</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Unidad</label>
                                <input id="Unidad" name="Unidad" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorUnidad"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Abreviatura</label>
                                <input id="Abreviatura" name="Abreviatura" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorAbreviatura"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Descripción</label>
                                <input id="Descripcion" name="Descripcion" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorDescripcion"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="GuardarUnidad()" type="button" class="btn btn-success">Crear Unidad</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

@endsection
