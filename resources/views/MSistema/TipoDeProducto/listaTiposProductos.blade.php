@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Tipos de Producto</h3></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="ajaxRenderSectionCrearTipoProducto()" type="button" class="btn btn-success">Crear nuevo</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" id="tablaTipoProductos">
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listTiposProductos as $tipo)
                                    <tr>
                                        <th scope="row">{{$tipo->id}}</th>
                                        <td>{{$tipo->Nombre}}</td>
                                        <td>{{$tipo->Descripcion}}</td>
                                        <td> <button onclick="ajaxRenderSectionEditarTipoProducto({{$tipo->id}})" type="button" class="btn btn-default" aria-label="Left Align" title="Editar Tipo Producto">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <link href="{{asset('js/Plugins/data-table/datatables.css')}}" rel="stylesheet">
    <!-- Plugins-->
    <script src="{{asset('js/Plugins/data-table/datatables.js')}}"></script>
    <script type="text/javascript">
        // Material Select Initialization
        $(document).ready(function() {
            $('#tablaTipoProductos').DataTable({
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
            });
        });

    </script>
@endsection
