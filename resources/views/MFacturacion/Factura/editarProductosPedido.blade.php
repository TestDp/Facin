@section('contentFormPedido')

    <div class="panel panel-info">

        <div class="panel-heading">Pedido N° {{$pedido->id}}
            <input type="hidden" id="idPedido" name="idPedido" value="{{$pedido->id}}" />
            <input type="hidden" id="esEditar" name="esEditar" value="true" />
            <input type="hidden" id="_tokenProductosPedido" name="_token" value="{{csrf_token()}}">
        </div>
        <div class="panel-body" id="productosSeleccionados">
            <table style="width:100%">
                <tr>
                    <th>Vendedor</th>
                    <th>Comentario</th>
                </tr>
                <tr>
                    <td>{{$nombreVendedor}}</td>
                    <td><input id="comentarioPedido" name="comentarioPedido" type="text" class="form-control" value="{{$pedido->Comentario}}" onchange="guadarComentario()"></td>
                </tr>
            </table>
            <br/>
            <table style="width:100%">
                <tr>
                    <td><select id="Producto_id" name="Producto_id"  class="form-control"  name="language" onchange="agregarProductoPedido()">
                            <option value="">Seleccionar Producto</option>
                            @foreach($listProductos as $producto)
                                <option value="{{ $producto->id }}" data-num="{{ $producto->Precio}}" data-title="{{ $producto->Nombre}}">{{$producto->Codigo}} - {{ $producto->Nombre }}</option>
                            @endforeach
                        </select></td>
{{--                    <td><button onclick="agregarProductoPedido(this)" type="button" class="btn btn-success">agregar</button></td>--}}
                </tr>
            </table>
            <br/>
            <table style="width:100%" id="tablaProductosSeleccionados">
                @foreach($productosXPedido as $productoPedido)

                    <tr id="rowPrducto" name="rowPrducto">
                        <td><input id="ProductoSecundario_id" name="ProductoSecundario_id" type="hidden" value="{{$productoPedido->Producto->id}}"/>
                            <input id="precioProducto" name="precioProducto" type="hidden" value="{{$productoPedido->Producto->Precio}}"/>
                            <input id="esEditarProducto" name="esEditarProducto" type="hidden" value="{{true}}"/>
                            <button class="btn boton-menos" type="button"><span class="glyphicon glyphicon-minus" onclick="restarCantidadProductoPedido(this)"></span></button>
                            <label class="cantidad" id="lbCantidad" name="lbCantidad">{{$productoPedido->Cantidad}}</label>
                            <button class="btn boton-mas" type="button"><span class="glyphicon glyphicon-plus" onclick="sumarCantidadProductoPedido(this)"></span></button></td>
                        <td><label class="nombre-producto"><p class="nombre-pedido-p" id="pNombreProducto" name="pNombreProducto">{{$productoPedido->Producto->Nombre}}</p></label></td>
                        <td><span class="glyphicon glyphicon-usd"></span>
                            <label class="precio-pedido" id="lbsubTotal" name="lbsubTotal">{{$productoPedido->SubTotal}}</label></td>
{{--                        <td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-comment"></span></button></td>--}}
                        <td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-remove" onclick="removerProductoPedido(this)"></span></button></td>
                    </tr>

                @endforeach
            </table>
            <br/>
            <table style="width:100%" >
                <tr>
                    <td colspan="4">Total</td>
                    <td colspan="2"><span class="glyphicon glyphicon-usd"></span>
                        <label class="precio-pedido" id="lbTotalPedido">{{$pedido->VentaTotal}}</label></td>
                </tr>
            </table>

        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-6">
                    <input type="button" id="BtnCerrarPedido"  class="form-control btn btn-info" value="facturar" data-toggle="modal" data-target="#modalFinalizarPedido" onclick="finalizarPedido()" disabled>
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
                                        <div class="col-md-6">
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
                                                                <th>Vlr Unitario</th>
                                                                <th>Vlr total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="TablasDetallePedido">
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="3">Total</th>
                                                                <td id="tdTotalPedido"></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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
                                                            <td><span class="glyphicon glyphicon-usd"></span><input type="number" class="precio-pedido" id="inputSubTotalMd" name="inputSubTotalMd" onkeyup="ValidarFormularioFinalizarPedido()"/></td>
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
                <div class="col-md-6">
                    <input type="button" class="form-control btn btn-danger" value="Eliminar" onclick="eliminarPedido()">
                </div>
            </div>
        </div>
    </div>
    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastselect.js') }}"></script>
<!--    <script src="{{ asset('js/Plugins/JsPDF/dist/jspdf.min.js') }}"></script>-->
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#Producto_id').fastselect({
                placeholder: 'Seleccione el producto',
                searchPlaceholder: 'Buscar productos'
            });
        });

    </script>

@endsection
