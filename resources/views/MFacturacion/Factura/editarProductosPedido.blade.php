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
                    <td>{{$pedido->Comentario}}</td>
                </tr>
            </table>
            <br/>
            <table style="width:100%">
                <tr>
                    <td><select id="Producto_id" name="Producto_id"  class="form-control"  name="language">
                            <option value="">Seleccionar Producto</option>
                            @foreach($listProductos as $producto)
                                <option value="{{ $producto->id }}" data-num="{{ $producto->Precio}}" data-title="{{ $producto->Nombre}}">{{$producto->Codigo}} - {{ $producto->Nombre }}</option>
                            @endforeach
                        </select></td>
                    <td><button onclick="agregarProductoPedido()" type="button" class="btn btn-success">agregar</button></td>
                </tr>
            </table>
            <br/>
            <table style="width:100%" id="tablaProductosSeleccionados">
            @foreach($productosXPedido as $productoPedido)

                    <tr id="rowPrducto" name="rowPrducto">
                        <td><input id="ProductoSecundario_id" name="ProductoSecundario_id" type="hidden" value="{{$productoPedido->Producto->id}}"/>
                            <button class="btn boton-menos" type="button"><span class="glyphicon glyphicon-minus" onclick="restarCantidadProductoPedido(this)"></span></button>
                            <label class="cantidad" id="lbCantidad" name="lbCantidad">{{$productoPedido->Cantidad}}</label>
                            <button class="btn boton-mas" type="button"><span class="glyphicon glyphicon-plus" onclick="sumarCantidadProductoPedido(this)"></span></button></td>
                        <td><label class="nombre-producto"><p class="nombre-pedido-p">{{$productoPedido->Producto->Nombre}}</p></label></td>
                        <td><span class="glyphicon glyphicon-usd"></span>
                            <label class="precio-pedido" id="lbTotal">{{$productoPedido->SubTotal}}</label></td>
                        <td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-comment"></span></button></td>
                        <td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-remove" onclick="removerProductoPedido(this)"></span></button></td>
                    </tr>

            @endforeach
                </table>

        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <input type="button" class="form-control btn btn-success" value="Guardar" onclick="ConfirmarProductosPedido()">
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastselect.js') }}"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#Producto_id').fastselect({
                placeholder: 'Seleccione el cliente',
                searchPlaceholder: 'Buscar productos'
            });
        });

    </script>

@endsection
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
                    <td>{{$pedido->Comentario}}</td>
                </tr>
            </table>
            <br/>
            <table style="width:100%">
                <tr>
                    <td><select id="Producto_id" name="Producto_id"  class="form-control"  name="language">
                            <option value="">Seleccionar Producto</option>
                            @foreach($listProductos as $producto)
                                <option value="{{ $producto->id }}" data-num="{{ $producto->Precio}}" data-title="{{ $producto->Nombre}}">{{$producto->Codigo}} - {{ $producto->Nombre }}</option>
                            @endforeach
                        </select></td>
                    <td><button onclick="agregarProductoPedido()" type="button" class="btn btn-success">agregar</button></td>
                </tr>
            </table>
            <br/>
            <table style="width:100%" id="tablaProductosSeleccionados">
                @foreach($productosXPedido as $productoPedido)
                        <tr id="rowPrducto" name="rowPrducto">
                            <td><input id="ProductoSecundario_id" name="ProductoSecundario_id" type="hidden" value="{{$productoPedido->Producto->id}}"/>
                                <button class="btn boton-menos" type="button"><span class="glyphicon glyphicon-minus" onclick="restarCantidadProductoPedido(this)"></span></button>
                                <label class="cantidad" id="lbCantidad" name="lbCantidad">{{$productoPedido->Cantidad}}</label>
                                <button class="btn boton-mas" type="button"><span class="glyphicon glyphicon-plus" onclick="sumarCantidadProductoPedido(this)"></span></button></td>
                            <td><label class="nombre-producto"><p class="nombre-pedido-p">{{$productoPedido->Producto->Nombre}}</p></label></td>
                            <td><span class="glyphicon glyphicon-usd"></span>
                                <label class="precio-pedido" id="lbTotal">{{$productoPedido->SubTotal}}</label></td>
                            <td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-comment"></span></button></td>
                            <td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-remove" onclick="removerProductoPedido(this)"></span></button></td>
                        </tr>
                @endforeach
            </table>

        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <input type="button" class="form-control btn btn-success" value="Guardar" onclick="ConfirmarProductosPedido()">
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastselect.js') }}"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#Producto_id').fastselect({
                placeholder: 'Seleccione el cliente',
                searchPlaceholder: 'Buscar productos'
            });
        });

    </script>

@endsection
