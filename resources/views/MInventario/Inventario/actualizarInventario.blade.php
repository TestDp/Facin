@extends('layouts.principal')

@section('content')
    <form id="formInventario">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Actualizar inventario</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                Producto
                                <select id="Producto_id" name="Producto_id"  class="form-control"  name="language">
                                    <option value="">Seleccionar</option>
                                    @foreach($listProductos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->Nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorProducto_id"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Cantidad
                                <input id="Cantidad" name="Cantidad" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorCantidad"></span>
                            </div>
                            <div class="col-md-4">
                                Precio de Compra por unidad
                                <input id="Precio" name="Precio" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorPrecio"></span>
                            </div>
                            <div class="col-md-4">
                                Número de factura
                                <input id="NumFacturaProvedor" name="NumFacturaProvedor" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorNumFacturaProvedor"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="GuardarInventario()" type="button" class="btn btn-success">Actualizar Inventario</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>

    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastselect.js') }}"></script>

    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#Proveedor_id').fastselect({
                placeholder: 'Seleccione el proveedor',
                searchPlaceholder: 'Buscar opciones'
            });
            $('#Producto_id').fastselect({
                placeholder: 'Seleccione el producto',
                searchPlaceholder: 'Buscar opciones'
            });
        });

    </script>
@endsection
