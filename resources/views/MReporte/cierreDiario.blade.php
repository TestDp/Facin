@extends('layouts.principal')

@section('content')
    <style>
        tr:hover {
            background-color: #dff0d8;
        }
    </style>

<div class="panel panel-success">
    <div class="panel-heading"><h3>Cierre Diario</h3></div>
    <div class="panel-body">
        <div class="row">
            <input type="date" id="filtrofechaActual" name="filtrofechaActual"  min="2018-01-01" max="2050-12-31" onchange="ajaxRenderSectionVisualizarInformeDarios($(this).val())"/>
        </div>
        <div class="row">
            <div class="col-md-6" id="tablaPedidosCompleta">
                <label>Ingresos</label>
                <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered"  >
                    <thead>
                    <tr>
                        <th scope="col">Medio de Pago</th>
                        <th scope="col">Valor</th>
                    </tr>
                    </thead>
                    <tbody id="tablaPedidos">
                    @foreach($ventasXDiaXMDD as $ventaXDiaMDD)
                        <tr>
                            <td>
                                @foreach($mediosPago as $medioPago)
                                    @if($medioPago->id == $ventaXDiaMDD->MedioDePago_id)
                                        {{$medioPago->Nombre}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                $ {{$ventaXDiaMDD->Total}}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th >Total</th>
                        <td colspan="2">$ {{$totalVenta}}</td>
                    </tr>
                    </tfoot>
                </table>

            </div>
            <div class="col-md-6" id="tablaPedidosCompleta">
                <label>Gastos</label>
                <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered"  >
                    <thead>
                    <tr>
                        <th scope="col">Descripción</th>
                        <th scope="col">Valor</th>
                    </tr>
                    </thead>
                    <tbody id="tablaPedidos">
                    @foreach($gastosProveedorXFecha as $gastoProveedorXFecha)
                        <tr>
                            <td >
                                {{$gastoProveedorXFecha->RazonSocial}}
                            </td>
                            <td>
                                $ {{$gastoProveedorXFecha->Total}}
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th >Total </th>
                        <td colspan="2">$ {{$totalGasto}}</td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="tablaPedidosCompleta">
                <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered"  >
                    <thead>
                    <tr>
                        <th scope="col">Total transferencias</th>
                        <th scope="col">Total caja</th>
                        <th scope="col">Total gastos</th>
                        <th scope="col">Total</th>
                    </tr>
                    </thead>
                    <tbody id="tablaPedidos">

                        <tr>
                            <td>
                                @php
                                    $totaltransferencias = 0;
                                    foreach($ventasXDiaXMDD as $ventaXDiaMDD)
                                       {    if($ventaXDiaMDD->MedioDePago_id == 2)
                                              {
                                                  $totaltransferencias = $ventaXDiaMDD->Total;
                                              }
                                        }

                                @endphp
                                $ {{$totaltransferencias}}

                            </td>
                            <td>
                                $ {{$totalVenta - $totaltransferencias }}
                            </td>
                            <td>
                                $ {{$totalGasto}}
                            </td>
                            <td>
                                $ {{$totalVenta - $totalGasto}}
                            </td>

                        </tr>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>





    <script type="text/javascript">

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

               $('#tablaPedidosCompleta a').css('color', '#dfecf6');
              //  $('#tablaPedidosCompleta').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="../images/loader.gif" />');

                var url = $(this).attr('href');
                getArticles(url);
                window.history.pushState("", "", url);
            });

            function getArticles(url) {
                $.ajax({
                    url : url
                }).done(function (data) {
                    $('#tablaPedidosCompleta').html(data);
                }).fail(function () {
                    alert('Articles could not be loaded.');
                });
            }
        });
    </script>

@endsection

