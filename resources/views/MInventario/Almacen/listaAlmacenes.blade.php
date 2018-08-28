@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Almacen</h3></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripcion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listAlmacenes as $almacen)
                            <tr>
                                <th scope="row">{{$almacen->id}}</th>
                                <td>{{$almacen->Nombre}}</td>
                                <td>{{$almacen->Ubicacion}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearAlmacen()" type="button" class="btn btn-success">Nuevo Almacen</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
