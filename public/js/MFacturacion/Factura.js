var urlBase = "";

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};


function ObtenerFormCrearPedido() {
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'formPedido',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        success: function (data) {
            OcultarPopupposition();
            $('#panelPedido').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
        }
    });
}


function guardarPedido() {
    var token = $("#_tokenPedido").val();
    var form = $("#formCrearPedido");
    PopupPosition();
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarPedido',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            $('#panelPedido').empty().append($(data.vista));
            var tr = '<tr>';
                tr = tr +'<td scope="col">'+data.Pedido.id +'</td>';
                tr = tr +'<td scope="col">'+data.Pedido.created_at+'</th>';
                tr = tr +'<td scope="col">'+data.Pedido.estado_factura.Nombre+'</td>';
                tr = tr +'<td scope="col">'+data.Pedido.cliente.Nombre +' '+ data.Pedido.cliente.Apellidos+'</td>';
                tr = tr +'<td scope="col">$0</td>';
                tr = tr +'</tr>';
            $("#tablaPedidos").append(tr);
        },
        error: function (data) {
            OcultarPopupposition();
        }
    });
}