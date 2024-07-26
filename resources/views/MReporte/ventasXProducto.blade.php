@extends('layouts.principal')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading"><h3>Ventas por producto</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="date" id="filtrofechaInicio" name="filtrofechaInicio"  min="2018-01-01" max="2050-12-31" />
                            </div>
                            <div class="col-md-2">
                                <input type="date" id="filtrofechaFinal" name="filtrofechaFinal"  min="2018-01-01" max="2050-12-31" />
                            </div>
                            <div class="col-md-2">
                                <button onclick="ajaxRenderSectionVisualizarVentasXProducto($('#filtrofechaInicio').val(),$('#filtrofechaFinal').val())" type="button" class="btn btn-success">consultar</button>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-6">
                                <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" >
                                    <thead>
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Ventas</th>
                                        <th scope="col">Cantidad</th>

                                    </tr>
                                    </thead>
                                    <tbody id="tablaCompras">
                                    @foreach($ventasXProducto as $producto)
                                        <tr>
                                            <td>{{$producto->Nombre}}</td>
                                            <td>{{$producto->Total}}</td>
                                            <td>{{$producto->cantidad}}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <canvas id="ventasXProducto" class="img-responsive"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

