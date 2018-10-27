@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <button  type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCrearCliente">Nuevo Cliente</button>
            </div>
            <!-- inicio modal crear cliente-->
            <form id="formCliente">
                <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}" />
                <input type="hidden" id="Empresa_id" name="Empresa_id" />
                <div id="modalCrearCliente" name="modalCrearEquivalencia"  tabindex="-1" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg" >
                        <!-- Modal content-->
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h3 class="modal-title">Crear Cliente </h3>
                            </div>
                            <div class="modal-body" >
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nombre</label>
                                        <input id="Nombre" name="Nombre" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorNombre"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Apellidos</label>
                                        <input id="Apellidos" name="Apellidos" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorApellidos"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Identificación</label>
                                        <input id="Identificacion" name="Identificacion" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorIdentificacion"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Teléfono</label>
                                        <input id="Telefono" name="Telefono" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorTelefono"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Correo Electrónico</label>
                                        <input id="CorreoElectronico" name="CorreoElectronico" type="text" class="form-control">
                                        <span class="invalid-feedback" role="alert" id="errorCorreoElectronico"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button onclick="GuardarCliente()" type="button" class="btn btn-success">Guardar Cliente</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
            <!-- fin modal crear cliente-->
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Pedidos</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <button onclick="ajaxRenderSectionCrearAlmacen()" type="button" class="btn btn-success">Nuevo Pedido</button>
                            </div>
                        </div>
                        <div class="row">
                            <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" id="tablaAlmacenes">
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Hora Pedido</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>a</td>
                                    <td>b</td>
                                    <td>a</td>
                                    <td>b</td>
                                    <td>a</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5" id="panelPedido">
                @yield('contentPedido')
            </div>
        </div>
    </div>

@endsection
