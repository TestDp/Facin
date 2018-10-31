@section('contentFormPedido')

    <div class="panel panel-info">
        <div class="panel-heading">Pedido N° {{$pedido->id}}</div>
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
                    <label>Producto</label>
                    <select id="Producto_id" name="Producto_id"  class="form-control"  name="language" onchange="ConsultarInfoProducto()">
                        <option value="">Seleccionar</option>
                        @foreach($listProductos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->Nombre }}</option>
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
                    <input type="button" class="form-control btn btn-success" value="Crear">
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
                searchPlaceholder: 'Buscar opciones'
            });
        });

    </script>

@endsection
