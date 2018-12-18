@extends('layouts.principal')

@section('content')
    <form id="formProveedor">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="Empresa_id" name="Empresa_id" >
        <input type="hidden" id="id" name="id" value="{{$proveedor->id}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Editar Proveedor</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                Razón Social
                                <input id="RazonSocial" name="RazonSocial" type="text"  class="form-control" value="{{$proveedor->RazonSocial}}">
                                <span class="invalid-feedback" role="alert" id="errorRazonSocial"></span>
                            </div>
                            <div class="col-md-4">
                                Nit
                                <input id="Nit" name="Nit" type="text" class="form-control" value="{{$proveedor->Nit}}">
                                <span class="invalid-feedback" role="alert" id="errorNit"></span>
                            </div>
                            <div class="col-md-4">
                                Nombre
                                <input id="Nombre" name="Nombre" type="text" class="form-control" value="{{$proveedor->Nombre}}">
                                <span class="invalid-feedback" role="alert" id="errorNombre"></span>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Apellidos
                                <input id="Apellidos" name="Apellidos" type="text" class="form-control" value="{{$proveedor->Apellidos}}">
                                <span class="invalid-feedback" role="alert" id="errorApellidos"></span>
                            </div>
                            <div class="col-md-4">
                                Tipo Documento
                                <select id="TipoDocumento_id" name="TipoDocumento_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listDoc as $tipo)
                                        @if ($tipo->id == $proveedor->TipoDocumento_id)
                                        <option value="{{ $tipo->id }}" selected>{{ $tipo->Nombre }}</option>
                                        @else
                                            <option value="{{ $tipo->id }}">{{ $tipo->Nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorTipoDocumento_id"></span>
                            </div>
                            <div class="col-md-4">
                                Número documento
                                <input id="Identificacion" name="Identificacion" type="text" class="form-control" value="{{$proveedor->Identificacion}}">
                                <span class="invalid-feedback" role="alert" id="errorIdentificacion"></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Correo Electrónico
                                <input id="CorreoElectronico" name="CorreoElectronico" type="text" class="form-control" value="{{$proveedor->CorreoElectronico}}">
                                <span class="invalid-feedback" role="alert" id="errorCorreoElectronico"></span>
                            </div>
                            <div class="col-md-4">
                                Teléfono
                                <input id="Telefono" name="Telefono" type="text" class="form-control" value="{{$proveedor->Telefono}}">
                                <span class="invalid-feedback" role="alert" id="errorTelefono"></span>
                            </div>
                            <div class="col-md-4">
                                Celular
                                <input id="Celular" name="Celular" type="text" class="form-control" value="{{$proveedor->Celular}}">
                                <span class="invalid-feedback" role="alert" id="errorCelular"></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                Terminos de Pago
                                <input id="Terminos_De_Pago" name="Terminos_De_Pago" type="text" class="form-control" value="{{$proveedor->Terminos_De_Pago}}">
                                <span class="invalid-feedback" role="alert" id="errorTerminos_De_Pago"></span>
                            </div>
                            <div class="col-md-6">
                                Descripción
                                <input id="Descripcion" name="Descripcion" type="text" class="form-control" value="{{$proveedor->Descripcion}}">
                                <span class="invalid-feedback" role="alert" id="errorDescripcion"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="GuardarProveedor()" type="button" class="btn btn-success">Actualizar</button>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>

@endsection
