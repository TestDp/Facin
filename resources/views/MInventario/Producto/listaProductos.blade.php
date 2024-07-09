@extends('layouts.principal')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <button onclick="ajaxRenderSectionCrearProducto()" type="button" class="btn btn-success">Nuevo Producto</button>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Productos</h3></div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" id="tablaProductos">
                                <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Precio Unidad</th>
                                    <th scope="col">stock(Cantidad)</th>
                                    <th scope="col">Prod Combo/Compuesto</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listProductos as $producto)
                                    <tr>
                                        <td>{{$producto->Codigo}}</td>
                                        <td>{{$producto->Nombre}}</td>
                                        <td>{{$producto->Precio}}</td>
                                        <td>{{$producto->Cantidad}}</td>
                                        <td>@if($producto->EsCombo == 1)
                                                Si
                                            @else
                                                No
                                            @endif</td>
                                        <td>
                                            @if($producto->EsCombo == 0)
                                                <button type="button" class="btn btn-default" aria-label="Left Align" title="Equivalencias"
                                                        data-toggle="modal" data-target="#modalCrearEquivalencia{{$producto->id}}"
                                                        onclick="ObtenerEquivalenciasProducto(this,{{$producto->id}})">
                                                    <span class="glyphicon glyphicon-transfer" aria-hidden="true" ></span>
                                                </button>
                                            @endif
                                            <!-- inicio modal crear equivalencia-->
                                            <div id="modalCrearEquivalencia{{$producto->id}}" name="modalCrearEquivalencia" class="modal fade" role="dialog">
                                                <div class="modal-dialog modal-lg">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title">Equivalencias </h3>
                                                        </div>
                                                        <div class="modal-body" >
                                                            <div class="row">
                                                                <h4>PRODUCTO: {{$producto->Nombre}} UNIDAD DE MEDIDA: {{$producto->Unidad}}</h4>
                                                            </div>
                                                            <hr />
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" id="tablaEquivalencias" name="tablaEquivalencias">
                                                                        <thead>
                                                                        <tr>
                                                                            <th scope="col">Producto Principal</th>
                                                                            <th scope="col">Unidad De Medida</th>
                                                                            <th scope="col">Producto Secundario</th>
                                                                            <th scope="col">Unidad De Medida</th>
                                                                            <th scope="col">Cantidad</th>
                                                                            <th scope="col"></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="bodytablaEquivalencias" name="bodytablaEquivalencias">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                            <div class="row">
                                                                <div class="col-md-4" id="divLisProductos" name="divLisProductos">
                                                                    Producto Secundario
                                                                    <select id="ListaProductos" name="ListaProductos"  class="form-control"  name="language" onchange="obtenerStringUnidad(this)">
                                                                        <option value="">Seleccionar</option>

                                                                    </select>
                                                                    <label class="invalid-feedback" role="alert" id="errorProductosList" name="errorProductosList"></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    Unidad de Medida Secundaria
                                                                    <div class="row" id="divUdSecundario" name="divUdSecundario">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    Cantidad de conversión
                                                                    <input id="cantidad" name="cantidad" type="number" class="form-control">

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <button onclick="guardarEquivalencia(this,{{$producto->id}})" type="button" class="btn btn-success">agregar equivalencia</button>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- fin modal crear equivalencia-->
                                            <button onclick="ajaxRenderSectionEditarProducto({{$producto->id}})"  type="button" class="btn btn-default" aria-label="Left Align" title="Editar Producto">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>
                                            </button>

<!--                                          <button onclick="ajaxRenderSectionDesactivarProducto({{$producto->id}})"  type="button" class="btn btn-default" aria-label="Left Align" title="Editar Producto">
                                                <span class="glyphicon glyphicon-ban-circle" aria-hidden="true" ></span>
                                            </button>

                                            <button onclick="ajaxRenderSectionActivarProducto({{$producto->id}})"  type="button" class="btn btn-default" aria-label="Left Align" title="Editar Producto">
                                                <span class="glyphicon glyphicon-align-center" aria-hidden="true" ></span>
                                            </button>-->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!!$listProductos->links()!!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <link href="{{asset('js/Plugins/data-table/datatables.css')}}" rel="stylesheet">
    <!-- Plugins-->
    <script src="{{asset('js/Plugins/data-table/datatables.js')}}"></script>
    <link href="{{ asset('js/Plugins/fastselect-master/dist/fastselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastsearch.js') }}"></script>
    <script src="{{ asset('js/Plugins/fastselect-master/dist/fastselect.js') }}"></script>
    <script src="{{ asset('js/Plugins/JsPDF/dist/jspdf.min.js') }}"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            /*$('#tablaProductos').DataTable({
                dom: 'B<"clear">lfrtip',
                buttons: {
                    name: 'primary',
                    text: 'Save current page'
                },
                language: {
                    "lengthMenu": "Registros por página _MENU_",
                    "info":"Mostrando del _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":"Mostrando del 0 a 0 de 0 registros",
                    "infoFiltered": "(Registros filtrados _MAX_ )",
                    "zeroRecords": "No hay registros",
                    "search": "Buscador:",
                    "paginate": {
                        "first":      "First",
                        "last":       "Last",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                }
            });*/

            $("#tablaProductos").find("select[name=ListaProductos]").each(function(ind,element){
                $(element).fastselect({
                    placeholder: 'Seleccione el producto',
                    searchPlaceholder: 'Buscar opciones'
                });
            });
            $("#tablaProductos").find("select[name=UnidadDeMedida_id]").each(function(ind,element){
                $(element).fastselect({
                    placeholder: 'Seleccione la unidad',
                    searchPlaceholder: 'Buscar opciones'
                });
            });

        });

    </script>
@endsection
