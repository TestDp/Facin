@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Usuarios</h3></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearUsuario()" type="button" class="btn btn-success">Nuevo Usuario</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" id="tablaUsuarios">
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Editar Usuario</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listUsuarios as $usuario)
                                    <tr>
                                        <th scope="row">{{$usuario->id}}</th>
                                        <td>{{$usuario->name}} {{$usuario->last_name}}</td>
                                        <td>{{$usuario->username}}</td>
                                        <td>{{$usuario->email}}</td>
                                        <td> <button onclick="ajaxRenderSectionEditarUsuario({{$usuario->id}})" type="button" class="btn btn-default" aria-label="Left Align" title="Editar Usuario">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>
                                            </button>
                                            <button   type="button" class="btn btn-default" data-toggle="modal" data-target="#modalContrasena{{$usuario->id}}" title="Cambiar contraseña">
                                                <span class="glyphicon glyphicon-lock" aria-hidden="true" ></span>
                                            </button>
                                            <!--modal cambio de contraseña-->
                                            <form id="formContrasena" name="formContrasena">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                                                <input type="hidden" id="id" name="id" value="{{$usuario->id}}">
                                                <div class="modal fade" id="modalContrasena{{$usuario->id}}" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Cambiar Contraseña a {{$usuario->name}}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        Contraseña
                                                                        <input id="password" name="password" type="password" class="form-control">
                                                                        <span class="invalid-feedback" role="alert" id="errorpassword"></span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        Confirmar Contraseña
                                                                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                                                                        <span class="invalid-feedback" role="alert" id="errorpassword_confirmation"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button onclick="CambiarContrasena(this)" type="button" class="btn btn-success" data-dismiss="modal">Cambiar</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </form>
                                            <!--modal cambio de contraseña-->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <link href="{{asset('js/Plugins/data-table/datatables.css')}}" rel="stylesheet">
    <!-- Plugins-->
    <script src="{{asset('js/Plugins/data-table/datatables.js')}}"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#tablaUsuarios').DataTable({
                dom: 'B<"clear">lfrtip',
                buttons: {
                    name: 'primary',
                    text: 'Save current page'
                },
                language: {
                    "lengthMenu": "Registros por página _MENU_",
                    "info":"Mostrando del _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":"Mostrando del 0 a 0 de 0 registros",
                    "infoFiltered": "(Registros filtrados _MAX_ )",
                    "zeroRecords": "No hay registros",
                    "search": "Buscador:",
                    "paginate": {
                        "first":      "First",
                        "last":       "Last",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                }
            });
        });

    </script>
@endsection
