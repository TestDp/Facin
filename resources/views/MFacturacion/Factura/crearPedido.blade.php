@section('contentFormPedido')
<form id="formCrearPedido">
    <input type="hidden" id="_tokenPedido" name="_tokenPedido" value="{{csrf_token()}}" />
    <div class="panel panel-info">
        <div class="panel-heading">Nuevo Pedido</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <label>Vendedor</label>
                    <input id="Vendedor" name="Vendedor" type="text" value="{{$nombreVendedor}}" class="form-control" readonly>
                    <span class="invalid-feedback" role="alert" id="errorVendedor"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Cliente</label>
                    <select id="Cliente_id" name="Cliente_id"  class="form-control">
                        <option value="">Seleccionar</option>
                        @foreach($ListClientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->Identificacion }}-{{ $cliente->Nombre }} {{ $cliente->Apellidos }}</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback" role="alert" id="errorCliente_id"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Comentario</label>
                    <textarea id="Comentario" name="Comentario" type="text" class="form-control"></textarea>
                    <span class="invalid-feedback" role="alert" id="errorComentario"></span>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <input type="button" id="BtnCerrarPedido"  class="form-control btn btn-info" value="facturar" data-toggle="modal" data-target="#modalFinalizarPedido" onclick="finalizarPedido()">
                    <!-- inicio modal finalizar  Pedido-->
                    <div id="modalFinalizarPedido" name="modalFinalizarPedido"   class="modal fade">
                        <div class="modal-dialog modal-lg" >
                            <!-- Modal content-->
                            <div class="modal-content" >
                                <div class="modal-header">
                                    <h3 class="modal-title">Finalizar Pedido   N° {{$pedido->id}} </h3>
                                </div>
                                <div class="modal-body" >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Cliente</label>
                                            <select id="Cliente_id" name="Cliente_id"  class="form-control">
                                                @foreach($ListClientes as $cliente)
                                                    <option value="{{ $cliente->id }}">{{ $cliente->Identificacion }}-{{ $cliente->Nombre }} {{ $cliente->Apellidos }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-success">
                                                <div class="panel-heading clearfix" >
                                                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Detalle Pedido</h4>
                                                </div>
                                                <div class="panel-body" id="tblExporFactura">
                                                    <table style="width:100%" class="table table-bordered">
                                                        <thead>
                                                        <tr >
                                                            <th>Cantidad</th>
                                                            <th>Producto</th>
                                                            <th>Vlr unitario</th>
                                                            <th>Vlr descuento</th>
                                                            <th>Vlr total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="TablasDetallePedido">
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <th colspan="4">Total</th>
                                                            <td id="tdTotalPedido"></td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-info">
                                                <div class="panel-heading clearfix">
                                                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Medios de Pago</h4>
                                                    <div class="btn-group pull-right">
                                                        <button class="btn btn-default btn-sm" type="button"><span class="glyphicon glyphicon-plus" onclick="agregarMedioDePago()"></span></button>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <table style="width:100%" class="table table-bordered">
                                                        <tbody id="TablaMediosPagos">
                                                        <tr>
                                                            <td>
                                                                <select class="form-control" id="selMedioPago" name="selMedioPago" onchange="validarMedioDePago(this),ValidarFormularioFinalizarPedido()">
                                                                    <option value="">seleccionar</option>
                                                                    @foreach($mediosPago as $medioPago)
                                                                        <option value="{{$medioPago->id}}">{{$medioPago->Nombre}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><span class="glyphicon glyphicon-usd"></span><input type="number" class="precio-pedido" id="inputSubTotalMd" name="inputSubTotalMd" onchange="ValidarFormularioFinalizarPedido()" onkeyup="ValidarFormularioFinalizarPedido()"/></td>
                                                            <td><button class="btn btn-default btn-sm" type="button"><span class="glyphicon glyphicon-remove" onclick="eliminarMedioDePago(this)"></span></button></td>
                                                        </tr>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <th >Vuelto</th>
                                                            <td id="tdVueltoPedido"></td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="cerrarModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button id="cerrarModalFinalizar" onclick="PagarPedido(this)" type="button" class="btn btn-success" data-dismiss="modal" disabled>Pagar</button>


                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- fin modal finalizar  Pedido-->
                </div>
                <div class="col-md-4">
                    <input type="button" class="form-control btn btn-danger" value="Eliminar" onclick="eliminarPedido()">
                </div>
            </div>
        </div>
    </div>
</form>
    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/JsPDF/dist/jspdf.min.js') }}"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#Cliente_id').fastselect({
                placeholder: 'Seleccione el cliente',
                searchPlaceholder: 'Buscar opciones'
            });
        });

    </script>

@endsection
