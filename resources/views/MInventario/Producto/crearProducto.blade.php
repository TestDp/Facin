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
                            </div>
                            <div class="col-md-4">
                                Nombre
                                <input id="Nombre" name="Nombre" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                Cantidad mínima
                                <input id="Cantidad" name="Cantidad" type="text" class="form-control">
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
                            </div>
                            <div class="col-md-4">
                                Unidad de Medida
                                <select id="UnidadDeMedida_id" name="UnidadDeMedida_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listUnidades as $unidad)
                                        <option value="{{ $unidad->id }}">{{ $unidad->Unidad }}({{$unidad->Abreviatura}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                Almacen
                                <select id="Almacen_id" name="Almacen_id"  class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($listAlmacenes as $almacen)
                                        <option value="{{ $almacen->id }}">{{ $almacen->Nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Precio Sin IVA
                                <input id="PrecioSinIva" name="PrecioSinIva" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                Precio Con IVA
                                <input id="PrecioSinIva" name="PrecioSinIva" type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                Precio venta
                                <input id="Precio" name="Precio" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Imagen producto
                                <input id="ImagenProducto" name="ImagenProducto" type="file" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel panel-warning">
                                <div class="panel-heading">PROVEEDOR</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Nombre
                                            <select id="Proveedor_id" name="Proveedor_id"  class="form-control">
                                                <option value="">Seleccionar</option>
                                                @foreach($listProveedores as $provedor)
                                                    <option value="{{ $provedor->id }}">{{ $provedor->Nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            Cantidad
                                            <input id="CantidadProveedor" name="CantidadProveedor" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            Precio de Compra
                                            <input id="PrecioProveedor" name="PrecioProveedor" type="text" class="form-control">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Número de factura
                                            <input id="NumFacturaProveedor" name="NumFacturaProveedor" type="text" class="form-control">
                                        </div>

                                    </div>
                                </div>
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

@endsection
