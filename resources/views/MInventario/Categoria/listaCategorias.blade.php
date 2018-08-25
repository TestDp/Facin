@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel">
                <div class="panel-heading"><h3>Categorias</h3></div>
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
                        @foreach($listCategorias as $categoria)
                            <tr>
                                <th scope="row">{{$categoria->id}}</th>
                                <td>{{$categoria->Nombre}}</td>
                                <td>{{$categoria->Descripcion}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>


@endsection
