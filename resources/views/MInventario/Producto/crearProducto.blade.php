@extends('layouts.principal')

@section('content')
    <form id="formProducto">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">

        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Crear Producto</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-1">
                                Combo
                                <input type="checkbox" value="1" class="form-control" id="EsCombo" name="EsCombo" onclick="mostrarYOcultarPanelAgregarProductos()" />
                            </div>
                            <div class="col-md-3">
                                Código
                                <input id="Codigo" name="Codigo" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorCodigo"></span>
                            </div>
                            <div class="col-md-4">
                                Nombre
                                <input id="Nombre" name="Nombre" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorNombre"></span>
                            </div>
                            <div class="col-md-4">
                                Tipo de Producto
                                <select id="TipoDeProducto_id" name="TipoDeProducto_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listTiposProductos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->Nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorTipoDeProducto_id"></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Categoria
                                <select id="Categoria_id" name="Categoria_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listCategorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->Nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorCategoria_id"></span>
                            </div>
                            <div class="col-md-4">
                                Unidad de Medida
                                <select id="UnidadDeMedida_id" name="UnidadDeMedida_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listUnidades as $unidad)
                                        <option value="{{ $unidad->id }}">{{ $unidad->Unidad }}({{$unidad->Abreviatura}})</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorUnidadDeMedida_id"></span>
                            </div>
                            <div class="col-md-4">
                                Almacen
                                <select id="Almacen_id" name="Almacen_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listAlmacenes as $almacen)
                                        <option value="{{ $almacen->id }}">{{ $almacen->Nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorAlmacen_id"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Costo
                                <input id="PrecioSinIva" name="PrecioSinIva" onkeyup="CalcularPrecioConIva()" type="number" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorPrecioSinIva"></span>
                            </div>
                            <div class="col-md-4">
                                Precio Con IVA
                                <input id="PrecioConIva" name="PrecioConIva" type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                Precio venta
                                <input id="Precio" name="Precio" type="number" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorPrecio"></span>
                            </div>
                        </div>
                        <div class="row" id="divProveedores">
                            <div class="col-md-12">
                                Proveedores
                                <select id="Proveedor_id" name="Proveedor_id"  class="form-control"  name="language">
                                    <option value="">Seleccionar</option>
                                    @foreach($listProveedores as $provedor)
                                        <option value="{{ $provedor->id }}">{{ $provedor->Nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorProveedor_id"></span>
                            </div>
                        </div>
                        <div class="row" id="divProductos" hidden>

                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><h3>Productos</h3></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <select id="ListaProductos" name="ListaProductos"  class="form-control"  name="language">
                                                <option value="">Seleccionar</option>
                                                @foreach($listProductos as $productos)
                                                    <option value="{{ $productos->id }}" data-num="{{ $productos->PrecioSinIva }}">{{ $productos->Nombre }}</option>
                                                @endforeach
                                            </select>
                                            <button onclick="agregarProducto()" type="button" class="btn btn-success">agregar Producto</button>
                                        </div>
                                        <div class="row">
                                            <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" id="tablaProductos">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Cantidad</th>
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
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            Imagen producto
                            <input id="ImagenProducto" name="ImagenProducto" type="file" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="validarCamposFormCrearProducto()" type="button" class="btn btn-success">Crear Producto</button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        </div>
    </form>

    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastselect.js') }}"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#Proveedor_id').fastselect({
                placeholder: 'Seleccione los proveedores',
                searchPlaceholder: 'Buscar opciones'
            });
            $('#ListaProductos').fastselect({
                placeholder: 'Seleccione los productos',
                searchPlaceholder: 'Buscar opciones'
            });
        });

    </script>
@endsection
