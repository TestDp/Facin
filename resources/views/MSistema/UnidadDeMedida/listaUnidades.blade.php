@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Unidades de medida</h3></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Unidad</th>
                            <th scope="col">Abreviatura</th>
                            <th scope="col">Descripción</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listUnidades as $unidad)
                            <tr>
                                <th scope="row">{{$unidad->id}}</th>
                                <td >{{$unidad->Unidad}}</td>
                                <td>{{$unidad->Abreviatura}}</td>
                                <td>{{$unidad->Descripcion}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearUnidad()" type="button" class="btn btn-success">Nueva Unidad</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
