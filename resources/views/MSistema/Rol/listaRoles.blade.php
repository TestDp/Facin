@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Roles</h3></div>
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
                        @foreach($listRoles as $roles)
                            <tr>
                                <th scope="row">{{$roles->id}}</th>
                                <td>{{$roles->Nombre}}</td>
                                <td>{{$roles->Descripcion}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearRol()" type="button" class="btn btn-success">Nuevo Rol</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
