@extends('layouts.principal')

@section('content')
    <style>
        tr:hover {
            background-color: #dff0d8;
        }
    </style>
    <div class="container">
     <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="panel panel-success">
                <div class="panel-heading"><h3>Compras</h3></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button onclick="ajaxRenderSectionRegistrarCompra()" type="button" class="btn btn-success">Nueva Compra</button>
                        </div>
                    </div>
                    <div class="row" id="tablaComprasCompleta">
                        <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered" >
                            <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Factura</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody id="tablaCompras">
                            @foreach($listCompras as $compra)
                                <tr onclick="ajaxRenderSectionConsultarCompra('{{$compra->created_at}}','{{$compra->NumFacturaProvedor}}')">
                                    <td>{{$compra->created_at}}</td>
                                    <td>{{$compra->NumFacturaProvedor}}</td>
                                    <td>{{$compra->RazonSocial}}</td>
                                    <td>{{$compra->Total}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!!$listCompras->links()!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5" id="panelPedido">
            @yield('contentFormPedido')
        </div>
    </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                $('#tablaComprasCompleta a').css('color', '#dfecf6');
                //  $('#tablaPedidosCompleta').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="../images/loader.gif" />');

                var url = $(this).attr('href');
                getArticles(url);
                window.history.pushState("", "", url);
            });

            function getArticles(url) {
                $.ajax({
                    url : url
                }).done(function (data) {
                    $('#tablaComprasCompleta').html(data);
                }).fail(function () {
                    alert('Articles could not be loaded.');
                });
            }
        });
    </script>
@endsection
