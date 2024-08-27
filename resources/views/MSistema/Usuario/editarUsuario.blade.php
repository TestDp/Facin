@extends('layouts.principal')

@section('content')
    <form id="formUsuario">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="id" name="id" value="{{$usuario->id}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Editar Usuario</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nombre</label>
                                <input id="name" name="name" type="text" class="form-control" value="{{$usuario->name}}">
                                <span class="invalid-feedback" role="alert" id="errorname"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Apellidos</label>
                                <input id="last_name" name="last_name" type="text" class="form-control"value="{{$usuario->last_name}}">
                                <span class="invalid-feedback" role="alert" id="errorlast_name"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Sede</label>
                                <select id="Sede_id" name="Sede_id"  class="form-control"  name="language">
                                    <option value="">Seleccionar</option>
                                    @foreach($listSedes as $sede)
                                        @if ($sede->id  == $usuario->Sede_id)
                                            <option value="{{ $sede->id }}" selected>{{ $sede->Nombre }}</option>
                                        @else
                                            <option value="{{ $sede->id }}">{{ $sede->Nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorSede_id"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Roles</label>
                                <select id="Roles_id" name="Roles_id[]"  class="form-control" multiple name="language">
                                    <option value="">Seleccionar</option>
                                    @foreach($listRoles as $rol)
                                        @php ($b = false)
                                        @foreach($rolesUsuario as $rolUsuario)
                                            @if($rolUsuario->Rol_id == $rol->id)
                                                @php ($b = true)
                                                @break
                                            @endif
                                        @endforeach
                                        @if($b)
                                            <option value="{{ $rol->id }}" selected>{{ $rol->Nombre }}</option>
                                        @else
                                            <option value="{{ $rol->id }}" >{{ $rol->Nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorRoles_id"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="ModificarUsuario()" type="button" class="btn btn-success">Editar usuario</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>

    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastselect.js') }}"></script>

    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#Sede_id').fastselect({
                placeholder: 'Seleccione la sede',
                searchPlaceholder: 'Buscar opciones'
            });
            $('#Roles_id').fastselect({
                placeholder: 'Seleccione los roles',
                searchPlaceholder: 'Buscar opciones'
            });
        });

    </script>
@endsection