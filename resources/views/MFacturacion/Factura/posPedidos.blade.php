@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">Pedido N° {{$pedido->id}}
            <input type="hidden" id="idPedido" name="idPedido" value="{{$pedido->id}}" />
            <input type="hidden" id="esEditar" name="esEditar" value="false" />
            <input type="hidden" id="_tokenProductosPedido" name="_token" value="{{csrf_token()}}">
        </div>
        <div class="panel-body" id="productosSeleccionados" name="productosSeleccionados">
            <table style="width:100%">
                <tr>
                    <th>Vendedor:</th>
                </tr>
                <tr>
                    <td>{{$nombreVendedor}}</td>
                </tr>
            </table>  <br/>
            <table style="width:100%">
                <tr>
                    <td><select id="Producto_id" name="Producto_id"  class="form-control"  name="language" onchange="agregarProductoPedido(true)">
                            <option value="">Seleccionar Producto</option>
                            @foreach($listProductos as $producto)
                                <option value="{{ $producto->id }}" data-num="{{ $producto->Precio}}" data-title="{{ $producto->Nombre}}">{{$producto->Codigo}} - {{ $producto->Nombre }}</option>
                            @endforeach
                        </select></td>
                    {{--                    <td><button onclick="agregarProductoPedido(this)" type="button" class="btn btn-success">agregar</button></td>--}}
                </tr>
            </table>
            <br/>
            <table style="width:100%"  class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Vlr unitario</th>
                        <th>Vlr descuento</th>
                        <th>Vlr subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tablaProductosSeleccionados">
                @foreach($productosXPedido as $productoPedido)

                   <tr id="rowPrducto" name="rowPrducto">
                        <td>
                            <input id="ProductoSecundario_id" name="ProductoSecundario_id" type="hidden" value="{{$productoPedido->Producto->id}}"/><input id="esEditarProducto" name="esEditarProducto" type="hidden" value="false"/>
                            <input id="precioProducto" name="precioProducto" type="hidden" value="{{$productoPedido->Producto->Precio}}"/>
                            <button class="btn boton-menos" type="button"><span class="glyphicon glyphicon-minus" onclick="restarCantidadProductoPedidoPos(this)"></span></button>
                            <input type="number" class="cantidad" id="lbCantidad" name="lbCantidad" value="{{$productoPedido->Cantidad}}" onchange="sumarCantEspeProdPedidoPos(this)"/>
                            <button class="btn boton-mas" type="button"><span class="glyphicon glyphicon-plus" onclick="sumarCantidadProductoPedidoPos(this)"></span></button></td>
                        <td><label class="nombre-producto"><p class="nombre-pedido-p" id="pNombreProducto" name="pNombreProducto">{{$productoPedido->Producto->Nombre}}</p></label></td>
                        <td>${{$productoPedido->Producto->Precio}}</td>
                        <td><span class="glyphicon glyphicon-usd"></span><input type="number" value="0" class="precio-pedido" id="inputDescuento" name="inputDescuento" onkeyup="ActualizarPrecioPedido(this)"/>
                            <input type="hidden" value="'+opcion.data('num')+'"  id="inputSubttalDtllPedido" name="inputSubttalDtllPedido"/>
                            <input type="hidden" value="'+opcion.val()+'"  id="inputIdProdDtllPedido" name="inputIdProdDtllPedido"/></td>
                        <td ><label name="lbsubTotal">{{$productoPedido->SubTotal}}</label></td>
                        <td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-remove" onclick="removerProductoPedido(this)" style="color:red"></span></button></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">SubTotal</th>
                        <td ><label id="lbTotalPedido">{{$pedido->VentaTotal}}</label></td>
                    </tr>
                    <tr>
                        <th colspan="4">Descuentos</th>
                        <td ><label id="tdDescuentos">{{$pedido->DescuentoTotal}}</label></td>
                    </tr>
                    <tr>
                        <th colspan="4">Total</th>
                        <td><label id="tdTotalPedido">{{$pedido->VentaTotal - $pedido->DescuentoTotal}}</label></td>
                    </tr>
                    <tr>
                        <th colspan="6">Medios de Pago</th>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control" id="selMedioPago" name="selMedioPago" onchange="validarMedioDePago(this),ValidarFormularioFinalizarPedido()">
                                <option value="">seleccionar</option>
                                @foreach($mediosPago as $medioPago)
                                    <option value="{{$medioPago->id}}">{{$medioPago->Nombre}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td colspan="4"><span class="glyphicon glyphicon-usd"></span><input type="number" class="precio-pedido" id="inputSubTotalMd" name="inputSubTotalMd" onchange="ValidarFormularioFinalizarPedido()" onkeyup="ValidarFormularioFinalizarPedido()"/></td>
                        <td colspan="2"><button class="btn btn-default btn-sm" type="button"><span class="glyphicon glyphicon-plus" style="color:blue" onclick="agregarMedioDePago()"></span></button></td>
                    </tr>
                    <tr>
                        <th colspan="4">Vuelto</th>
                        <td id="tdVueltoPedido"></td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div class="panel-footer">
            <div class="row">

                <div class="col-md-6">
                    <input type="button" id="BtnCerrarPedido"  class="form-control btn btn-info" value="facturar" data-toggle="modal" data-target="#modalFinalizarPedido" onclick="finalizarPedido()" disabled>
                    <!-- inicio modal finalizar  Pedido-->
                    <div id="modalFinalizarPedido" name="modalFinalizarPedido"   class="modal fade">
                        <div class="modal-dialog modal-dialog-centered" >
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
                                                                <th colspan="4">SubTotal</th>
                                                                <td id="tdSubTotalPedido"></td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="4">Descuentos</th>
                                                                <td id="tdDescuentos">0</td>
                                                            </tr>
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
    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css')}}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js')}}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastselect.js') }}"></script>

    <script src="{{ asset('js/Plugins/JsPDF/dist/jspdf.min.js') }}"></script>
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
