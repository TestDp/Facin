@section('contentFormPedido')

    <div class="panel panel-info">

        <div class="panel-heading">Detalle Factura N° {{$pedido->id}}
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

            <br/>
            <table style="width:100%" class="table table-bordered">
                <thead>
                <tr >
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Vlr Unitario</th>
                    <th>Vlr descuento</th>
                    <th>Vlr Subtotal</th>
                </tr>
                </thead>
                @foreach($productosXPedido as $productoPedido)
                    <tbody id="TablasDetallePedido">
                        <tr id="rowPrducto" name="rowPrducto">
                            <td>{{$productoPedido->Producto->Nombre}}</td>
                            <td>{{$productoPedido->Cantidad}}</td>
                            <td>{{$productoPedido->Producto->Precio}}</td>
                            <td>{{$productoPedido->Descuento}}</td>
                            <td>${{$productoPedido->SubTotal - $productoPedido->Descuento}}</td>
                        </tr>
                    </tbody>
                @endforeach
                <tfoot>
                    <tr>
                        <th colspan="4">SubTotal</th>
                        <td id="tdSubTotalPedido">$ {{$pedido->VentaTotal}}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Descuentos</th>
                        <td id="tdDescuentos">{{$pedido->DescuentoTotal}}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Total</th>
                        <td id="tdTotalPedido">$ {{$pedido->VentaTotal - $pedido->DescuentoTotal}}</td>
                    </tr>
                    <tr>
                        <th colspan="5" >Forma de pago</th>
                    </tr>

                    @foreach($detallePagoFactura as $detallePago)
                        <tr>
                            <td colspan="4">
                                @foreach($mediosPago as $medioPago)
                                    @if($medioPago->id == $detallePago->MedioDePago_id)
                                        {{$medioPago->Nombre}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                               $ {{$detallePago->Valor}}
                            </td>

                        </tr>
                    @endforeach

                </tfoot>
            </table>

            <br/>
            @if($pedido->EstadoFactura_id == 2)
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6">
                        <input type="button" class="form-control btn btn-success" value="Imprimir factura" onclick="imprimirFactura()">
                    </div>
                    @if(Auth::user()->buscarRecurso('AnularFactura'))
                        <div class="col-md-6">
                            <input type="button" class="form-control btn btn-danger" value="Anular factura" onclick="anularFactura()">
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

    </div>
    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/JsPDF/dist/jspdf.min.js') }}"></script>
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
