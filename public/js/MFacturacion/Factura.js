var urlBase = "";

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

//function para mostar la vista donde se crea el pedido
function ObtenerFormCrearPedido() {
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'formPedido',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        success: function (data) {
            $("#tablaPedidos").find('tr').removeAttr('style');
            OcultarPopupposition();
            $('#panelPedido').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
        }
    });
}

//function para mostar la vista donde se listan los pedidos
function ajaxRenderSectionVistaListaPedidos(idEstado) {
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'listaPedidos/'+ idEstado,
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        success: function (data) {
            OcultarPopupposition();
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
        }
    });
}

//function para guardar el pedido solo con el cliente, el vendedor y el comentario
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
            var tr = '<tr style="background: #dff0d8" id="trPedido'+data.Pedido.id+'" onclick="validarEdicionDePedido(this,'+data.Pedido.id+')">';
            tr = tr +'<td scope="col">'+data.Pedido.id +'</td>';
            tr = tr +'<td scope="col">'+data.Pedido.created_at+'</th>';
            tr = tr +'<td scope="col" id="tdEstadoPedido'+data.Pedido.id+'">'+data.Pedido.estado_factura.Nombre+'</td>';
            tr = tr +'<td scope="col">'+data.Pedido.cliente.Nombre +' '+ data.Pedido.cliente.Apellidos+'</td>';
            tr = tr +'<td scope="col" id="tdTotalPedido'+data.Pedido.id+'">$0</td>';
            tr = tr +'</tr>';
            $("#tablaPedidos").append(tr);
        },
        error: function (data) {
            OcultarPopupposition();
            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
        }
    });
}

//funcion para agregar un producto al pedido
function agregarProductoPedido() {
    var opcion= $('#Producto_id').find('option:selected');//obtenemos la opcion seleccionada
    if(opcion.val() !=''){
        if(!buscarProductoSecundario(opcion.val()))
        {
            DeshabilitarBtnDeCerrarPedido();//se hace el llamado a desabilitar el boton de cerrar pedido cuando se esta editando el pedido.
            var idProducto = $('#Producto_id').val();
            $.ajax({
                type: 'GET',
                url: urlBase +'infoProducto/'+idProducto,
                dataType: 'json',
                success: function (data) {
                    if(data.Cantidad == 0){
                        swal({
                            title: "Producto sin existencia!",
                            text: "El producto  seleccionado no tiene existencia en inventario!",
                            icon: "error",
                            button: "OK",
                        });
                    }else{
                        agregarHtmlFilProducto(opcion);
                        DeshabilitarBtnDeCerrarPedido();
                    }
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    if (errors) {
                        $.each(errors, function (i) {
                            console.log(errors[i]);
                        });
                    }
                }
            });
        }else{
            swal({
                title: "Operación incorrecta!",
                text: "El producto ya fue seleccionado!",
                icon: "error",
                button: "OK",
            });
        }
    }
}

function agregarHtmlFilProducto(opcion) {
    var row = '<tr id="rowPrducto" name="rowPrducto">';
        row = row + '<td>';
        row = row + '<input id="ProductoSecundario_id" name="ProductoSecundario_id" type="hidden" value="'+opcion.val()+'"/><input id="precioProducto" name="precioProducto" type="hidden" value="'+opcion.data('num')+'"/>';
        row = row + '<button class="btn boton-menos" type="button"><span class="glyphicon glyphicon-minus" onclick="restarCantidadProductoPedido(this)"></span></button>';
        row = row + '<label class="cantidad" id="lbCantidad" name="lbCantidad">1</label>';
        row = row + '<button class="btn boton-mas" type="button"><span class="glyphicon glyphicon-plus" onclick="sumarCantidadProductoPedido(this)"></span></button></td>';
        row = row + '<td><label class="nombre-producto"><p class="nombre-pedido-p" id="pNombreProducto" name="pNombreProducto">'+opcion.data('title')+'</p></label></td>';
        row = row + '<td><span class="glyphicon glyphicon-usd"></span>';
        row = row + '<label class="precio-pedido" id="lbsubTotal" name="lbsubTotal">'+opcion.data('num')+'</label></td>';
        row = row + '<td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-comment"></span></button></td>';
        row = row + '<td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-remove" onclick="removerProductoPedido(this)"></span></button></td>';
        row = row + '</tr>';
    $('#tablaProductosSeleccionados').append(row);
    calcularTotalPedido();
}

//funcion para sumar 1 a la cantidad del producto del pedido
function sumarCantidadProductoPedido(element) {
    var row = $(element).closest("tr[name=rowPrducto]");
    var label = row.find("label[name=lbCantidad]");
    var precioProducto = parseInt(row.find("input[name=precioProducto]").val());
    var labelCantidad = row.find("label[name=lbCantidad]").text();
    var labelSubtotal = row.find("label[name=lbsubTotal]");
    var cantidad = parseInt(labelCantidad) + 1;
    label.html(cantidad);
    labelSubtotal.html(cantidad * precioProducto);
    calcularTotalPedido();
    DeshabilitarBtnDeCerrarPedido();
}

//funcion para restar 1 a la cantidad del producto del pedido
function restarCantidadProductoPedido(element) {
    var row = $(element).closest("tr[name=rowPrducto]");
    var label = row.find("label[name=lbCantidad]");
    var precioProducto = parseInt(row.find("input[name=precioProducto]").val());
    var labelCantidad = row.find("label[name=lbCantidad]").text();
    var labelSubtotal = row.find("label[name=lbsubTotal]");
    var cantidad = parseInt(labelCantidad) - 1;
    label.html(cantidad);
    labelSubtotal.html(cantidad * precioProducto);
    calcularTotalPedido();
    DeshabilitarBtnDeCerrarPedido();
}

//funcion para calcular el total del pedido
function calcularTotalPedido(){
    var totalPedido = 0;
    $("#tablaProductosSeleccionados").find("label[name=lbsubTotal]").each(function(ind,lbSubtotal){
        totalPedido = totalPedido + parseInt($(lbSubtotal).text());
    });
    $("#lbTotalPedido").html(totalPedido);
    return totalPedido;
}

//funcion para remover un producto del pedido
function removerProductoPedido(element){
    swal({
        title: 'Está Seguro?',
        text: "Esta seguro que desea quitar el producto con sus cantidades!",
        icon: 'warning',
        buttons: {
            cancel: {
                text: "Cancel",
                value: false,
                visible: true,
                className: "",
                closeModal: true,
            },
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "",
                closeModal: true
            }},
    }).then((result) => {
        if (result) {
            $(element).closest("tr[name=rowPrducto]").remove();
            calcularTotalPedido();
            DeshabilitarBtnDeCerrarPedido();
        }
    });
}

//funcion para confirmar los productos del pedido(factura)
function ConfirmarProductosPedido() {
    var arregloProductosPedido =  new Array();
    $("#productosSeleccionados").find("tr[name=rowPrducto]").each(function(ind,row){
            var producto = new Object();
                producto.Producto_id = $(row).find("input[name=ProductoSecundario_id]").val();
                producto.Cantidad = $(row).find("label[name=lbCantidad]").text();
                producto.Factura_id =  $("#idPedido").val();
                producto.Comentario = "prueba comentario";
                producto.EsEditar = $("#esEditar").val();
        arregloProductosPedido.push(producto);
    });

    var token = $("#_tokenProductosPedido").val();
    $.ajax({
        type: 'POST',
        url: urlBase +'confirmarProductosPedido',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:{'array': JSON.stringify(arregloProductosPedido)},
        success: function (data) {
            var mensajeRespuesta="El pedido fue confirmado con exito!"
            if(data.Respuesta){
                if($("#esEditar").val() =='true'){
                    mensajeRespuesta ="El pedido fue modficado con exito!"
                }
                swal({
                    title: "Transaccción exitosa!",
                    text: mensajeRespuesta,
                    icon: "success",
                    button: "OK",
                });
                var stringTdtotalPedido = '#tdTotalPedido'+$("#idPedido").val();
                $(stringTdtotalPedido).html("$"+data.PrecioTotal);
                $(stringTdtotalPedido).closest("tr").attr("onclick","validarEdicionDePedido(this,"+$("#idPedido").val()+")");
                habilitarBtnDeCerrarPedido();
                if($("#esEditar").val() =='false'){
                    $('#panelPedido').empty();
                }
            }else{
                if(data.SinExistencia){
                    swal({
                        title: "Producto sin existencia!",
                        text: "El producto "+data.producto+" solo tiene "+data.cantidad+" cantidades disponibles",
                        icon: "error",
                        button: "OK",
                    });
                }else{
                    swal({
                        title: "Operación incorrecta!",
                        text: "No fue posible confirmar el pedido!",
                        icon: "error",
                        button: "OK",
                    });
                }

            }
        },
        error: function (data) {
            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
        }
    });

}

//funcion para editar los producto del pedido(factura)
function editarPedido(element,idFactura) {
    pintarFilaSelecciona(element);
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'editarPedido/'+idFactura,
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $('#panelPedido').empty().append($(data.vista));
        },
        error: function (data) {
            OcultarPopupposition();
            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
        }
    });
}

//funcion para mostar el detalle y los medios de pagos en el modal de finalizar pedido(factura)
function finalizarPedido(){
    $("#TablasDetallePedido").html("");
    $("#productosSeleccionados").find("tr[name=rowPrducto]").each(function(ind,row){

        var valorSuTotal = parseFloat($(row).find("label[name=lbsubTotal]").text());
        var cantidad = parseFloat($(row).find("label[name=lbCantidad]").text());
        var valorUnidad = valorSuTotal/cantidad;
        var tr='<tr>';
        tr = tr +'<td>'+cantidad+'</td>';
        tr = tr +'<td>'+$(row).find("p[name=pNombreProducto]").text()+'</td>';
        tr = tr +'<td>$'+valorUnidad+'</td>';
        tr = tr +'<td>$'+valorSuTotal+'</td>';
        tr = tr +'</tr>';
        $("#TablasDetallePedido").append(tr);

    });
    $("#tdTotalPedido").html('$'+$("#lbTotalPedido").text());
}

//funcion para listar los medios de pago en el momento de finalizar el pedido(factura)
function agregarMedioDePago() {
    $.ajax({
        type: 'GET',
        url: urlBase +'mediosDePagolist',
        dataType: 'json',
        success: function (data) {
        var tr='<tr>';
            tr = tr +'<td>';
            tr= tr+'<select class="form-control" id="selMedioPago" name="selMedioPago">'
            $.each(data, function (i,medioPago){
                tr = tr +'<option value="'+medioPago.id+'">'+medioPago.Nombre+'</option>';
            });
            tr= tr+'</select></td>';
            tr= tr+'<td><span class="glyphicon glyphicon-usd"></span><input type="number" class="precio-pedido" id="inputSubTotalMd" name="inputSubTotalMd" onkeyup="calcularVuelto()"/></td>';
            tr= tr+'<td><button class="btn btn-default btn-sm"" type="button"><span class="glyphicon glyphicon-remove" onclick="eliminarMedioDePago(this)"></span></button></td>';
            tr= tr+'</tr>';
            $("#TablaMediosPagos").append(tr);
        },
        error: function (data) {

            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
        }
    });

}

//funcion para eliminar el medio de pago en el momento de finalizar el pedido(factura)
function eliminarMedioDePago(element){
    swal({
        title: 'Está Seguro?',
        text: "Esta seguro que desea quitar el medio de pago!",
        icon: 'warning',
        buttons: {
            cancel: {
                text: "Cancel",
                value: false,
                visible: true,
                className: "",
                closeModal: true,
            },
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "",
                closeModal: true
            }},
    }).then((result) => {
        if (result) {
            $(element).closest("tr").remove();
        }
    });
}

//funcion para calcular la devuelta del pago del pedido(factura)
function calcularVuelto() {
    var totalPedido = calcularTotalPedido();
    var totalPagado = 0;
    $("#TablaMediosPagos").find("input[name=inputSubTotalMd]").each(function(ind,lbSubtotal){
        totalPagado = totalPagado + parseInt($(lbSubtotal).val());
    });
    var vuelto = totalPagado-totalPedido;
    $("#tdVueltoPedido").html("$"+vuelto);
}

//funcion para realizar el paggo del pedido(factura)
function PagarPedido() {
    var arregloMediosDepago =  new Array();
    $("#TablaMediosPagos").find("tr").each(function(ind,row){
        var medioDePagoXPedido = new Object();
        medioDePagoXPedido.Valor = $(row).find("input[name=inputSubTotalMd]").val();
        medioDePagoXPedido.MedioDePago_id = $(row).find("select[name=selMedioPago]").val();
        medioDePagoXPedido.Factura_id =  $("#idPedido").val();
        arregloMediosDepago.push(medioDePagoXPedido);
    });

    var token = $("#_tokenProductosPedido").val();
    $.ajax({
        type: 'POST',
        url: urlBase +'pagarPedido',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:{'array': JSON.stringify(arregloMediosDepago)},
        success: function (data) {
            if(data.Respuesta){
                swal({
                    title: "Transaccción exitosa!",
                    text: "El pedido fue pagado con exito!",
                    icon: "success",
                    button: "OK",
                });
                var stringTrtotalPedido = '#trPedido'+$("#idPedido").val();
                var stringTdEstadoPedido = '#tdEstadoPedido'+$("#idPedido").val();
                $(stringTrtotalPedido).removeAttr("onclick");
                $(stringTdEstadoPedido).html("Finalizada");
                $('#panelPedido').empty();
               /* window.onload = function(){
                    window.print($("#TablasDetallePedido").html());
                }*/
                var doc = new jsPDF();
                doc.text(20, 20, 'Hola mundo');
                doc.text(20, 30, 'Vamos a generar un pdf desde el lado del cliente');
                // Save the PDF
                doc.save('documento.pdf');
            }
        },
        error: function (data) {
            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
        }
    });
}

//funcion para pintar la fila del pedido en la que se esta trabajando
function pintarFilaSelecciona(element){
    $(element).closest('tbody').find('tr').removeAttr('style');
    $(element).closest('tr').attr("style","background: #dff0d8");
}

//funcion para deshabilitar el boton cuando se esta editando un pedido para obligar al usuario a relizar nuevamente
//la confirmacion o guardado del pedido
function DeshabilitarBtnDeCerrarPedido(){
    $("#BtnCerrarPedido").attr("disabled","disabled");
}

//funcion para habilitar el funcion cuando se se confirmo o se guardo el pedido
function habilitarBtnDeCerrarPedido(){
    $("#BtnCerrarPedido").removeAttr("disabled");
}

//Funcion para validar si el pedido se esta editando
function validarEdicionDePedido(element,idFactura){
    if($("#BtnCerrarPedido").is(':disabled')){
        swal({
            title: '¡El pedido se está editando!',
            text: "¿Está seguro que desea descartar los cambios realizados?",
            icon: 'warning',
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "OK",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true
                }},
        }).then((result) => {
            if (result) {
                editarPedido(element,idFactura);
            }
        });
    }else{
        editarPedido(element,idFactura);
    }
}

//Funcion para validar si el pedido se esta editando desde el boton de crear pedido
function validarEdicionDePedidoBtnCrear(element,idFactura){
    if($("#BtnCerrarPedido").is(':disabled')){
        swal({
            title: '¡Un Pedido se esta editando!',
            text: "¿Está seguro que desea descartar los cambios realizados?",
            icon: 'warning',
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "OK",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true
                }},
        }).then((result) => {
            if (result) {
                ObtenerFormCrearPedido(element,idFactura);
            }
        });
    }else{
        ObtenerFormCrearPedido(element,idFactura);
    }
}