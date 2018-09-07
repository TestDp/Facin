@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Usuarios</h3></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Correo</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listUsuarios as $usuario)
                            <tr>
                                <th scope="row">{{$usuario->id}}</th>
                                <td>{{$usuario->name}} {{$usuario->last_name}}</td>
                                <td>{{$usuario->username}}</td>
                                <td>{{$usuario->email}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearUsuario()" type="button" class="btn btn-success">Nuevo Usuario</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
