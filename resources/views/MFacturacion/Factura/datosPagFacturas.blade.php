<table style="border-collapse: collapse !important; border-spacing: 0 !important; width: 100% !important;" class="table table-bordered"  >
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Hora Pedido</th>
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