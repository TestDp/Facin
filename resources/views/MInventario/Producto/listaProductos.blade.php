@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Productos</h3></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Precio</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listProductos as $producto)
                            <tr>
                                <th scope="row">{{$producto->id}}</th>
                                <td>{{$producto->Nombre}}</td>
                                <td>{{$producto->Precio}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearCategoria()" type="button" class="btn btn-success">Nueva Producto</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
