@extends('layouts.principal')

@section('content')
    <form id="formCompra">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Registrar Compra</h3></div>
                    <div class="panel-body">
                        <div class="row" id="divProveedores">
                            <div class="col-md-8">
                                Proveedor
                                <select id="Proveedor_id" name="Proveedor_id"  class="form-control"  name="language">
                                    <option value="">Seleccionar</option>
                                    @foreach($listProveedores as $provedor)
                                        <option value="{{ $provedor->id }}">{{ $provedor->RazonSocial }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorProveedor_id"></span>
                            </div>
                            <div class="col-md-4">
                                Número de factura
                                <input id="NumFacturaProvedor" name="NumFacturaProvedor" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorNumFacturaProvedor"></span>
                            </div>
                        </div>
                        <div class="row" id="divProductos">

                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><h3>Productos</h3></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <select id="Producto" name="Producto"  class="form-control"  name="language">
                                                <option value="">Seleccionar</option>
                                                @foreach($listProductos as $productos)
                                                    <option value="{{ $productos->id }}" data-num="{{ $productos->PrecioSinIva }}">{{ $productos->Nombre }}</option>
                                                @endforeach
                                            </select>
                                            <button onclick="agregarProductoCompra()" type="button" class="btn btn-success">Agregar Producto</button>
                                        </div>
                                        <div class="row">
                                            <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" id="tablaProductos">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">Precio de Compra</th>
                                                    <th scope="col">Precio de Venta</th>
                                                    <th scope="col">SubTotal</th>
                                                    <th scope="col"></th>
                                                </tr>
                                                </thead>
                                                <tbody id="productosSeleccionados">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Comentarios/Observaciones
                                <textarea id="Comentarios" name="Comentarios" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="validarCamposFormCrearProductoCompra()" type="button" class="btn btn-success">Guardar Compra</button>
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
            $('#Producto').fastselect({
                placeholder: 'Seleccione el producto',
                searchPlaceholder: 'Buscar opciones'
            });
        });

    </script>
@endsection
