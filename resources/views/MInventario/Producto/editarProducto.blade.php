@extends('layouts.principal')

@section('content')
    <form id="formProducto">
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="id" name="id" value="{{$producto->id}}">

        <div class="container">
            <div class="row justify-content-center">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Editar Producto</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-1">
                                Combo
                                <input type="checkbox" value="1" class="form-control" id="EsCombo" name="EsCombo" onclick="mostrarYOcultarPanelAgregarProductos()" />
                            </div>
                            <div class="col-md-3">
                                Código
                                <input id="Codigo" name="Codigo" type="text" class="form-control" value="{{$producto->Codigo}}">
                                <span class="invalid-feedback" role="alert" id="errorCodigo"></span>
                            </div>
                            <div class="col-md-4">
                                Nombre
                                <input id="Nombre" name="Nombre" type="text" class="form-control" value="{{$producto->Nombre}}">
                                <span class="invalid-feedback" role="alert" id="errorNombre"></span>
                            </div>
                            <div class="col-md-4">
                                Tipo de Producto
                                <select id="TipoDeProducto_id" name="TipoDeProducto_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listProd as $tipo)
                                        @if ($tipo->id == $producto->TipoDeProducto_id)
                                            <option value="{{ $tipo->id }}" selected>{{ $tipo->Nombre }}</option>
                                        @else
                                            <option value="{{ $tipo->id }}">{{ $tipo->Nombre }}</option>
                                        @endif
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
                                    @foreach($listCat as $tipo)
                                        @if ($tipo->id == $producto->Categoria_id)
                                            <option value="{{ $tipo->id }}" selected>{{ $tipo->Nombre }}</option>
                                        @else
                                            <option value="{{ $tipo->id }}">{{ $tipo->Nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorCategoria_id"></span>
                            </div>
                            <div class="col-md-4">
                                Unidad de Medida
                                <select id="UnidadDeMedida_id" name="UnidadDeMedida_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listUni as $tipo)
                                        @if ($tipo->id == $producto->UnidadDeMedida_id)
                                            <option value="{{ $tipo->id }}" selected>{{ $tipo->Unidad }}</option>
                                        @else
                                            <option value="{{ $tipo->id }}">{{ $tipo->Unidad }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorUnidadDeMedida_id"></span>
                            </div>
                            <div class="col-md-4">
                                Almacen
                                <select id="Almacen_id" name="Almacen_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listAlma as $tipo)
                                        @if ($tipo->id == $producto->Almacen_id)
                                            <option value="{{ $tipo->id }}" selected>{{ $tipo->Nombre }}</option>
                                        @else
                                            <option value="{{ $tipo->id }}">{{ $tipo->Nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorAlmacen_id"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Costo
                                <input id="PrecioSinIva" name="PrecioSinIva" onkeyup="CalcularPrecioConIva()" type="number" class="form-control" value="{{$producto->PrecioSinIva}}">
                                <span class="invalid-feedback" role="alert" id="errorPrecioSinIva"></span>
                            </div>
                            <div class="col-md-4">
                                Precio Con IVA
                                <input id="PrecioConIva" name="PrecioConIva" type="text" class="form-control"  value="{{$producto->PrecioSinIva + $producto->PrecioSinIva *0.19}}" disabled>
                            </div>
                            <div class="col-md-4">
                                Precio venta
                                <input id="Precio" name="Precio" type="number" class="form-control" value="{{$producto->Precio}}">
                                <span class="invalid-feedback" role="alert" id="errorPrecio"></span>
                            </div>
                        </div>
                        <div class="row" id="divProveedores">
                            <div class="col-md-12">
                                Proveedores
                                <select id="Proveedor_id" name="Proveedor_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listProv as $proveedor)
                                        @if ($proveedor->id == $productoXprovedor->Proveedor_id)
                                            <option value="{{ $proveedor->id }}" selected>{{ $proveedor->Nombre }}</option>
                                        @else
                                            <option value="{{ $proveedor->id }}">{{ $proveedor->Nombre }}</option>
                                        @endif
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
                                            <select id="TipoDeProducto_id" name="TipoDeProducto_id"  class="form-control">
                                                <option value="">Seleccionar</option>
                                                @foreach($listProd as $tipo)
                                                    @if ($tipo->id == $producto->TipoDeProducto_id)
                                                        <option value="{{ $tipo->id }}" selected>{{ $tipo->Nombre }}</option>
                                                    @else
                                                        <option value="{{ $tipo->id }}">{{ $tipo->Nombre }}</option>
                                                    @endif
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
                            <button onclick="validarCamposFormCrearProducto()" type="button" class="btn btn-success">Actualizar</button>
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
            /**$('#ListaProductos').fastselect({
                placeholder: 'Seleccione los productos',
                searchPlaceholder: 'Buscar opciones'
            });**/
        });

    </script>
@endsection
