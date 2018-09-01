@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Tipos de Documentos</h3></div>
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
                        @foreach($listDoc as $tipo)
                            <tr>
                                <th scope="row">{{$tipo->id}}</th>
                                <td>{{$tipo->Nombre}}</td>
                                <td>{{$tipo->Descripcion}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearTipoDocumento()" type="button" class="btn btn-success">Nueva Tipo</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
