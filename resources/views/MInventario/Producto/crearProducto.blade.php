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
                            <div class="col-md-4">
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
                                Cantidad mínima
                                <input id="Cantidad" name="Cantidad" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorCantidad"></span>
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
                                Precio Sin IVA
                                <input id="PrecioSinIva" name="PrecioSinIva" onkeyup="CalcularPrecioConIva()" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorPrecioSinIva"></span>
                            </div>
                            <div class="col-md-4">
                                Precio Con IVA
                                <input id="PrecioConIva" name="PrecioConIva" type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                Precio venta
                                <input id="Precio" name="Precio" type="text" class="form-control">
                                <span class="invalid-feedback" role="alert" id="errorPrecio"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Proveedores
                                <select id="Proveedor_id" name="Proveedor_id[]"  class="form-control" multiple name="language">
                                    <option value="">Seleccionar</option>
                                    @foreach($listProveedores as $provedor)
                                        <option value="{{ $provedor->id }}">{{ $provedor->Nombre }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert" id="errorProveedor_id"></span>
                            </div>
                            <div class="col-md-8">
                                Imagen producto
                                <input id="ImagenProducto" name="ImagenProducto" type="file" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="GuardarProducto()" type="button" class="btn btn-success">Crear Producto</button>
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
                    placeholder: 'Seleccione los proveedores',
                    searchPlaceholder: 'Buscar opciones'
            });
        });

    </script>
@endsection
