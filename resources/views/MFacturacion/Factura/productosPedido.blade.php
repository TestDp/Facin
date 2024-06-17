@section('contentFormPedido')
    <div class="panel panel-info">
        <div class="panel-heading">Pedido N° {{$pedido->id}}
            <input type="hidden" id="idPedido" name="idPedido" value="{{$pedido->id}}" />
            <input type="hidden" id="esEditar" name="esEditar" value="false" />
            <input type="hidden" id="_tokenProductosPedido" name="_token" value="{{csrf_token()}}">
        </div>
        <div class="panel-body" id="productosSeleccionados">
            <table style="width:100%">
                <tr>
                    <th>Vendedor:</th>
                    <th>Comentario</th>

                </tr>
                <tr>
                    <td>{{$nombreVendedor}}</td>
                    <td><input id="comentarioPedido" name="comentarioPedido" type="text" class="form-control"></td>
                </tr>
            </table>  <br/>
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
            </table>
            <br/>
            <table style="width:100%" >
                <tr>
                    <td colspan="4">Total</td>
                    <td colspan="2"><span class="glyphicon glyphicon-usd"></span>
                        <label class="precio-pedido" id="lbTotalPedido">0</label></td>
                </tr>
            </table>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <input id="btnConfirmarPedido" type="button" class="form-control btn btn-success" value="Confirmar" onclick="ConfirmarProductosPedido(this)" disabled>
                </div>
                <div class="col-md-4">
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
