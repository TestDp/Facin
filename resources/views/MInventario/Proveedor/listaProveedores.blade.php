@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Proveedores</h3></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Nit</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Telefono</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listProveedores as $proveedor)
                            <tr>
                                <th scope="row">{{$proveedor->id}}</th>
                                <td>{{$proveedor->Nombre}} {{$proveedor->Apellidos}}</td>
                                <td>{{$proveedor->Nit}}</td>
                                <td>{{$proveedor->Celular}}</td>
                                <td>{{$proveedor->Telefono}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearProveedor()" type="button" class="btn btn-success">Nuevo Proveedor</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
