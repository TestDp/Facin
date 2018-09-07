@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Sedes</h3></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Telefono</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listSedes as $sede)
                            <tr>
                                <th scope="row">{{$sede->id}}</th>
                                <td >{{$sede->Nombre}}</td>
                                <td>{{$sede->Direccion}}</td>
                                <td>{{$sede->Telefono}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearSede()" type="button" class="btn btn-success">Nueva Sede</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
