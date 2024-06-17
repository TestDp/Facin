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
                    <div class="panel-heading"><h3>Facturas</h3></div>
                    <div class="panel-body">

                        <div class="row" id="tablaPedidosCompleta">
                            <table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered"  >
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Total</th>
                                </tr>
                                </thead>
                                <tbody id="tablaPedidos">
                                @foreach($listPedidos as $pedido)
                                    <tr onclick="validarEdicionDePedido(this,{{$pedido->id}})" id="trPedido{{$pedido->id}}">
                                        <td>{{$pedido->id}}</td>
                                        <td>{{$pedido->created_at}}</td>
                                        <td id="tdEstadoPedido{{$pedido->id}}">{{$pedido->nombreEstado}}</td>
                                        <td>{{$pedido->Nombre}} {{$pedido->Apellidos}}</td>
                                        <td id="tdTotalPedido{{$pedido->id}}">${{$pedido->VentaTotal}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!!$listPedidos->links()!!}
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

