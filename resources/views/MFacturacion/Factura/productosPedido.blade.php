@section('contentFormPedido')
    <div class="panel panel-info">
        <div class="panel-heading">Pedido N° {{$pedido->id}}
            <input type="hidden" id="idPedido" name="idPedido" value="{{$pedido->id}}" />
            <input type="hidden" id="_tokenProductosPedido" name="_token" value="{{csrf_token()}}">
        </div>
        <div class="panel-body" id="productosSeleccionados">
            <div class="row">
                <div class="col-md-12">
                    <p>Vendedor: {{$nombreVendedor}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Comentario: {{$pedido->Comentario}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <select id="Producto_id" name="Producto_id"  class="form-control"  name="language">
                        <option value="">Seleccionar Producto</option>
                        @foreach($listProductos as $producto)
                            <option value="{{ $producto->id }}" data-num="{{ $producto->Precio}}" data-title="{{ $producto->Nombre}}">{{$producto->Codigo}} - {{ $producto->Nombre }}</option>
                        @endforeach
                    </select>
                    <button onclick="agregarProductoPedido()" type="button" class="btn btn-success">agregar</button>
                </div>
            </div>

        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <input type="button" class="form-control btn btn-success" value="Confirmar" onclick="ConfirmarProductosPedido()">
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
