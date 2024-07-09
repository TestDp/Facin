@section('contentFormPedido')

    <div class="panel panel-info">


        <div class="panel-heading" id="DetalleCompra">  </div>
        <div class="panel-body" id="productosSeleccionados">
            <table style="width:100%" class="table table-bordered">
                <thead>
                <tr >
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Vlr Unitario</th>
                    <th>Vlr Subtotal</th>
                </tr>
                </thead>
                @foreach($listaProductosCompra as $productoCompra)
                    <tbody id="TablasDetallePedido">
                        <tr id="rowPrducto" name="rowPrducto">
                            <td>{{$productoCompra->Nombre}}</td>
                            <td>{{$productoCompra->Cantidad}}</td>
                            <td>{{$productoCompra->Precio}}</td>
                            <td>${{$productoCompra->Cantidad * $productoCompra->Precio}}</td>
                        </tr>
                    </tbody>
                @endforeach

            </table>




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
