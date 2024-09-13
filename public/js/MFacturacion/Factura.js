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
function guardarPedido(element) {
    element.disabled = true;
    var token = $("#_tokenPedido").val();
    var form = $("#formCrearPedido");
    PopupPosition();
    $.ajax({
       // type: 'POST',
        type: 'GET',
        url: urlBase +'guardarPedido',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
       // data:form.serialize(),
        success: function (data) {
            element.disabled = false;
            OcultarPopupposition();
            $('#panelPedido').empty().append($(data.vista));
            var comentario = (data.Pedido.Comentario == null) ? '': data.Pedido.Comentario;
            var fechaPedido = data.Pedido.created_at.split('T')[0];
            var horaPedido = (data.Pedido.created_at.split('T')[1]).split('.')[0];
            var tr = '<tr style="background: #dff0d8" id="trPedido'+data.Pedido.id+'" onclick="validarEdicionDePedido(this,'+data.Pedido.id+')">';
            tr = tr +'<td scope="col">'+data.Pedido.id +'</td>';
            tr = tr +'<td scope="col">'+fechaPedido +' '+ horaPedido + '</th>';
            tr = tr +'<td scope="col" id="tdEstadoPedido'+data.Pedido.id+'">'+data.Pedido.estado_factura.Nombre+'</td>';
            tr = tr +'<td scope="col" id="tdComentarioPedido'+data.Pedido.id+'">'+ comentario  + '</td>';
            tr = tr +'<td scope="col" id="tdTotalPedido'+data.Pedido.id+'">$0</td>';
            tr = tr +'</tr>';
            $("#tablaPedidos").prepend(tr);

        },
        error: function (data) {
            element.disabled = false;
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
    // element.disabled = true;
    var opcion= $('#Producto_id').find('option:selected');//obtenemos la opcion seleccionada
    if(opcion.val() !=''){
        if(!buscarProductoSecundario(opcion.val()))
        {
            var idProducto = $('#Producto_id').val();
            var idFactura = $("#idPedido").val();
            $.ajax({
                type: 'GET',
                url: urlBase +'agregarProductosPedido/'+ idFactura + '/'+ idProducto ,
                dataType: 'json',
                success: function (data) {
                    //element.disabled = false;
                    if(data.Cantidad <= 1){
                        swal({
                            title: "Producto sin existencia!",
                            text: "El producto  seleccionado no tiene existencia en inventario!",
                            icon: "error",
                            button: "OK",
                        });

                    }else{
                        agregarHtmlFilProducto(opcion);
                        habilitarBtnDeCerrarPedido();
                        var stringTdtotalPedido = '#tdTotalPedido'+ idFactura;
                        $(stringTdtotalPedido).html("$"+data.PrecioTotal);
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
       // row = row + '<input id="ProductoSecundario_id" name="ProductoSecundario_id" type="hidden" value="'+opcion.val()+'"/><input id="esEditarProducto" name="esEditarProducto" type="hidden" value="false"/><input id="precioProducto" name="precioProducto" type="hidden" value="'+opcion.data('num')+'"/>';
        row = row + '<input id="ProductoSecundario_id" name="ProductoSecundario_id" type="hidden" value="'+opcion.val()+'"/><input id="esEditarProducto" name="esEditarProducto" type="hidden" value="false"/><input id="precioProducto" name="precioProducto" type="hidden" value="'+opcion.data('num')+'"/>';
        row = row + '<button class="btn boton-menos" type="button"><span class="glyphicon glyphicon-minus" onclick="restarCantidadProductoPedido(this)"></span></button>';
        row = row + '<label class="cantidad" id="lbCantidad" name="lbCantidad">1</label>';
        row = row + '<button class="btn boton-mas" type="button"><span class="glyphicon glyphicon-plus" onclick="sumarCantidadProductoPedido(this)"></span></button></td>';
        row = row + '<td><label class="nombre-producto"><p class="nombre-pedido-p" id="pNombreProducto" name="pNombreProducto">'+opcion.data('title')+'</p></label></td>';
        row = row + '<td><span class="glyphicon glyphicon-usd"></span>';
        row = row + '<label class="precio-pedido" id="lbsubTotal" name="lbsubTotal">'+opcion.data('num')+'</label></td>';
        //row = row + '<td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-comment"></span></button></td>';
        row = row + '<td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-remove" onclick="removerProductoPedido(this)"></span></button></td>';
        row = row + '</tr>';
    $('#tablaProductosSeleccionados').append(row);
    calcularTotalPedido();
}

//funcion para sumar 1 a la cantidad del producto del pedido
function sumarCantidadProductoPedido(element) {
    var row = $(element).closest("tr[name=rowPrducto]");
    var label = row.find("label[name=lbCantidad]");
    var labelCantidad = row.find("label[name=lbCantidad]").text();
    var cantidad = parseInt(labelCantidad) + 1;
    label.html(cantidad);
    var idProducto = $(element).closest("tr[name=rowPrducto]").find("input[name=ProductoSecundario_id]").val();
    var idFactura = $("#idPedido").val();
    $.ajax({
        type: 'GET',
        url: urlBase +'agregarProductosPedido/'+ idFactura + '/'+ idProducto ,
        dataType: 'json',
        success: function (data) {

            if(data.Cantidad <= 1){
                label.html(cantidad - 1);
                swal({
                    title: "Producto sin existencia!",
                    text: "El producto  seleccionado no tiene existencia en inventario!",
                    icon: "error",
                    button: "OK",
                });

            }else{
                var precioProducto = parseInt(row.find("input[name=precioProducto]").val());
                var labelSubtotal = row.find("label[name=lbsubTotal]");
                labelSubtotal.html(cantidad * precioProducto);
                calcularTotalPedido();
                habilitarBtnDeCerrarPedido();
                var stringTdtotalPedido = '#tdTotalPedido'+ idFactura;
                $(stringTdtotalPedido).html("$"+data.PrecioTotal);
            }
        },
        error: function (data) {
            label.html(cantidad - 1);
            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
        }
    });


}

//funcion para restar 1 a la cantidad del producto del pedido
function restarCantidadProductoPedido(element) {
    element.disabled = true;
    var row = $(element).closest("tr[name=rowPrducto]");
    var labelCantidad = row.find("label[name=lbCantidad]").text();
    var cantidad = parseInt(labelCantidad) - 1;
    if(cantidad >= 1){
        var label = row.find("label[name=lbCantidad]");
        label.html(cantidad);
        var idProducto = $(element).closest("tr[name=rowPrducto]").find("input[name=ProductoSecundario_id]").val();
        var idFactura = $("#idPedido").val();
        $.ajax({
            type: 'GET',
            url: urlBase +'restarProductosPedido/'+ idFactura + '/'+ idProducto ,
            dataType: 'json',
            success: function (data) {
                element.disabled = false;
                if(data.Respuesta){
                    var precioProducto = parseInt(row.find("input[name=precioProducto]").val());
                    var labelSubtotal = row.find("label[name=lbsubTotal]");
                    var stringTdtotalPedido = '#tdTotalPedido'+ idFactura;
                    $(stringTdtotalPedido).html("$"+data.PrecioTotal);
                    labelSubtotal.html(cantidad * precioProducto);
                    calcularTotalPedido();
                }else{
                    label.html(cantidad + 1);
                    swal({
                        title: "Operación incorrecta!",
                        text: "no fue posible restar la cantidad, intenta de nuevo!",
                        icon: "error",
                        button: "OK",
                    });
                }

            },
            error: function (data) {
                element.disabled = false;
                var errors = data.responseJSON;
                if (errors) {
                    $.each(errors, function (i) {
                        console.log(errors[i]);
                    });
                }
            }
        });
    }

}

//funcion para calcular el total del pedido
function calcularTotalPedido(){
    var totalPedido = 0;
    $("#tablaProductosSeleccionados").find("label[name=lbsubTotal]").each(function(ind,lbSubtotal){
        totalPedido = totalPedido + parseInt($(lbSubtotal).text());
    });
    $("#lbTotalPedido").html(totalPedido);
    return totalPedido - CalcularDescuentoTotal();
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
            var row = $(element).closest("tr[name=rowPrducto]");
            var labelCantidad = row.find("label[name=lbCantidad]").text();
            var cantidad = parseInt(labelCantidad);
            var idProducto = row.find("input[name=ProductoSecundario_id]").val();
            var idFactura = $("#idPedido").val();
            $(element).closest("tr[name=rowPrducto]").remove();
            $.ajax({
                type: 'GET',
                url: urlBase +'eliminarProductosPedido/'+ idFactura + '/'+ idProducto + '/' +  cantidad,
                dataType: 'json',
                success: function (data) {
                    if(data.Respuesta){
                        var label = row.find("label[name=lbCantidad]");
                        var precioProducto = parseInt(row.find("input[name=precioProducto]").val());
                        var labelSubtotal = row.find("label[name=lbsubTotal]");
                        var stringTdtotalPedido = '#tdTotalPedido'+ idFactura;
                        $(stringTdtotalPedido).html("$"+data.PrecioTotal);
                        label.html(cantidad);
                        labelSubtotal.html(cantidad * precioProducto);
                        calcularTotalPedido();
                    }else{
                        swal({
                            title: "Operación incorrecta!",
                            text: "no fue posible restar la cantidad, intenta de nuevo!",
                            icon: "error",
                            button: "OK",
                        });
                    }
                    if($(element).closest("div[name=productosSeleccionados]").find("tr[name=rowPrducto]").length == 0){
                        desHabilitarBtnDeCerrarPedido();
                    }
                },
                error: function (data) {
                    calcularTotalPedido();
                    if($(element).closest("div[name=productosSeleccionados]").find("tr[name=rowPrducto]").length == 0){
                        desHabilitarBtnDeCerrarPedido();
                    }
                    var errors = data.responseJSON;
                    if (errors) {
                        $.each(errors, function (i) {
                            console.log(errors[i]);
                        });
                    }
                }
            });

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
            habilitarBtnDeCerrarPedido();
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
        var idProd = parseFloat($(row).find("input[name=ProductoSecundario_id]").val());
        var valorUnidad = valorSuTotal/cantidad;
        var tr='<tr>';
        tr = tr +'<td>'+cantidad+'</td>';
        tr = tr +'<td>'+$(row).find("p[name=pNombreProducto]").text()+'</td>';
        tr = tr +'<td>$'+valorUnidad+'</td>';
        tr = tr +'<td><input type="number" value="0" class="precio-pedido" id="inputDescuento" name="inputDescuento" onkeyup="ActualizarPrecioPedido(this)"/>' +
            '<input type="hidden" value="'+valorSuTotal+'"  id="inputSubttalDtllPedido" name="inputSubttalDtllPedido"/>' +
            '<input type="hidden" value="'+idProd+'"  id="inputIdProdDtllPedido" name="inputIdProdDtllPedido"/></td>';
        tr = tr +'<td name="tdSubttalDtllPedido">$'+valorSuTotal+'</td>';
        tr = tr +'</tr>';
        $("#TablasDetallePedido").append(tr);

    });
    $("#tdSubTotalPedido").html('$'+$("#lbTotalPedido").text());
    $("#tdTotalPedido").html('$'+$("#lbTotalPedido").text());
}

function eliminarPedido(){
    swal({
        title: 'Está Seguro?',
        text: "Esta seguro que desea eliminar el pedido!",
        icon: 'warning',
        buttons: {
            cancel: {
                text: "Cancelar",
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
            cambiarEstadoFactura($('#idPedido').val(),3,"El pedido fue eliminado con exito!",'Eliminado');
        }
    });

}

function anularFactura(){
    swal({
        title: 'Está Seguro?',
        text: "Esta seguro que desea anular la factura!",
        icon: 'warning',
        buttons: {
            cancel: {
                text: "Cancelar",
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
            cambiarEstadoFactura($('#idPedido').val(),4,'La factura fue anulada con exito!','Anulada');
        }
    });
}

function cambiarEstadoFactura(idFactura,idEstadoFactura,mensaje,nombreEstado){
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'cambiarEstadoFactura/' + idFactura + '/' + idEstadoFactura,
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            if(data.Respuesta){
                swal({
                    title: "Transaccción exitosa!",
                    text: mensaje,
                    icon: "success",
                    button: "OK",
                });
                var stringTrtotalPedido = '#trPedido'+idFactura;
                $(stringTrtotalPedido).removeAttr("onclick");
                var stringTdEstadoPedido = '#tdEstadoPedido' + idFactura;
                $(stringTdEstadoPedido).html(nombreEstado);
                $('#panelPedido').empty();

            }
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

//funcion para listar los medios de pago en el momento de finalizar el pedido(factura)
function agregarMedioDePago() {
    $.ajax({
        type: 'GET',
        url: urlBase +'mediosDePagolist',
        dataType: 'json',
        success: function (data) {
        var tr='<tr>';
            tr = tr +'<td>';
            tr= tr+'<select class="form-control" id="selMedioPago" name="selMedioPago" onchange="validarMedioDePago(this)">'
            tr = tr +'<option value="">seleccionar</option>';
            $.each(data, function (i,medioPago){
                tr = tr +'<option value="'+medioPago.id+'">'+medioPago.Nombre+'</option>';
            });
            tr= tr+'</select></td>';
            tr= tr+'<td><span class="glyphicon glyphicon-usd"></span><input type="number" class="precio-pedido" id="inputSubTotalMd" name="inputSubTotalMd" onkeyup="ValidarFormularioFinalizarPedido()"/></td>';
            tr= tr+'<td><button class="btn btn-default btn-sm"" type="button"><span class="glyphicon glyphicon-remove" onclick="eliminarMedioDePago(this)"></span></button></td>';
            tr= tr+'</tr>';
            $("#TablaMediosPagos").append(tr);
            $("#cerrarModalFinalizar").attr('disabled','disabled');
           // $("#cerrarModalFinalizar").removeAttr("disabled");
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

function validarMedioDePago(element){
    var cant = 0
    $("#TablaMediosPagos").find("select[name=selMedioPago]").each(function(ind,selMedioPago){
       if($(selMedioPago).val() == $(element).val()){
           cant++;
       }

    });
    if( cant > 1){
        $(element).val("");
        swal({
            title: "Operación incorrecta!",
            text: "El medio de pago ya fue seleccionado!",
            icon: "error",
            button: "OK",
        });
    }

}

function ValidarFormularioFinalizarPedido(){
    var vuelto =  calcularVuelto();
    var respuestaVuelto = false;
    var cantSelFalse = 0;
    if(vuelto >= 0){
        respuestaVuelto = true;
    }
    $("#TablaMediosPagos").find("select[name=selMedioPago]").each(function(ind,selMedioPago){
        if($(selMedioPago).val() == ''){
            $("#cerrarModalFinalizar").attr('disabled','disabled')
            $(selMedioPago).after('<label class="error-dinamico">Seleccione un medio de pago</label>');
            cantSelFalse++;
        }
    });
    if(respuestaVuelto && cantSelFalse == 0){
        $("#cerrarModalFinalizar").removeAttr("disabled");
        return true;
    }else{
        $("#cerrarModalFinalizar").attr('disabled','disabled');
        return false;
    }

}

//funcion para eliminar el medio de pago en el momento de finalizar el pedido(factura)
function eliminarMedioDePago(element){
    swal({
        title: 'Está Seguro?',
        text: "Esta seguro que desea quitar el medio de pago!",
        icon: 'warning',
        buttons: {
            cancel: {
                text: "Cancelar",
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
            ValidarFormularioFinalizarPedido();
        }
    });
}

//funcion para calcular la devuelta del pago del pedido(factura)
function calcularVuelto() {
    var totalPedido = calcularTotalPedido();
    var totalPagado = 0;
    $("#TablaMediosPagos").find("input[name=inputSubTotalMd]").each(function(ind,lbSubtotal){
        totalPagado = totalPagado + parseInt($(lbSubtotal).val() !="" ? $(lbSubtotal).val() : 0);
    });
    var vuelto = totalPagado-totalPedido;
    $("#tdVueltoPedido").html("$"+vuelto);
    return vuelto;
}

//funcion para realizar el pago del pedido(factura)
var estaPagando = true;
function PagarPedido(element) {
    element.disabled = true;
    if(estaPagando){
        estaPagando = false;
        var arregloMediosDepago =  new Array();
        var arregloDescuentoXProd = new Array();
        $("#TablasDetallePedido").find("tr").each(function(ind,row){
            var descuentoXProducto = new Object();
            descuentoXProducto.valorDescuento = $(row).find("input[name=inputDescuento]").val();
            descuentoXProducto.idProdDtllPedido = $(row).find("input[name=inputIdProdDtllPedido]").val();
            arregloDescuentoXProd.push(descuentoXProducto);
        });
        $("#TablaMediosPagos").find("tr").each(function(ind,row){
            var medioDePagoXPedido = new Object();
            medioDePagoXPedido.nombreMedioPago = $(row).find("select[name=selMedioPago]").find('option:selected').text();
            medioDePagoXPedido.Valor = $(row).find("input[name=inputSubTotalMd]").val();
            medioDePagoXPedido.MedioDePago_id = $(row).find("select[name=selMedioPago]").val();
            arregloMediosDepago.push(medioDePagoXPedido);
        });
        var dataPagoPedido = new Object();
        dataPagoPedido.mediosDePago = arregloMediosDepago;
        dataPagoPedido.descuentosXproductos = arregloDescuentoXProd;
        dataPagoPedido.descuentoTotal = CalcularDescuentoTotal();
        dataPagoPedido.Factura_id = $("#idPedido").val();
        dataPagoPedido.clienteidPedido = $("#Cliente_id").val();
        var token = $("#_tokenProductosPedido").val();
        $.ajax({
            type: 'POST',
            url: urlBase +'pagarPedido',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': token},
            data:{'array': JSON.stringify(dataPagoPedido)},
            success: function (data) {
                estaPagando = true;
                if(data.Respuesta){
                    swal({
                        title: "Transaccción exitosa!",
                        text: "El pedido fue pagado con exito!",
                        icon: "success",
                        button: "OK",
                    });
                    var stringTrtotalPedido = '#trPedido'+$("#idPedido").val();
                    var stringTdEstadoPedido = '#tdEstadoPedido'+$("#idPedido").val();
                    var stringTdtotalPedido = '#tdTotalPedido'+$("#idPedido").val();
                    $(stringTrtotalPedido).removeAttr("onclick");
                    $(stringTdEstadoPedido).html("Finalizada");
                    var total = data.pedido.VentaTotal - data.pedido.DescuentoTotal;
                    $(stringTdtotalPedido).html(total);
                    $('#panelPedido').empty();
                    crearPdfFactura(arregloMediosDepago,data.nombreVendedor,data.productosXPedido,data.pedido,data.empresa);

                }
            },
            error: function (data) {
                estaPagando = true;
                var errors = data.responseJSON;
                if (errors) {
                    $.each(errors, function (i) {
                        console.log(errors[i]);
                    });
                }
            }
        });

    }
    element.disabled = false;
}

function imprimirFactura(){
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'imprimirFactura/' + $('#idPedido').val(),
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            var  arregloMediosDepago = data.detallePagoFactura.map(medio => {
                var nombreMedioPago = {};
                nombreMedioPago['nombreMedioPago'] = medio.medio_de_pago.Nombre;
                return nombreMedioPago
            });
            crearPdfFactura(arregloMediosDepago,data.nombreVendedor,data.productosXPedido,data.pedido,data.empresa);
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

function crearPdfFactura(arregloMediosDepago,nombreVendedor,productosXPedido,pedido,empresa){
    var cantidadProductos = productosXPedido.length * 5;
   var opciones = {
        orientation: 'p',
        unit: 'mm',
        format: [75, 160 + cantidadProductos]
    };
    var specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function(element, renderer){
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    }
    var totalLinea = 65;
    var doc = new jsPDF(opciones);
    doc.setFontSize(12);
    doc.text(empresa.RazonSocial, doc.internal.pageSize.width/2, 5, null, null, 'center');
    doc.text('Nit: ' + empresa.NitEmpresa, doc.internal.pageSize.width/2, 10, null, null, 'center');
    doc.text('Telefono : ' + empresa.Telefono, doc.internal.pageSize.width/2, 15, null, null, 'center');
    doc.text(empresa.Direccion, doc.internal.pageSize.width/2, 20, null, null, 'center');
    doc.text('Rionegro Antioquia', doc.internal.pageSize.width/2, 25, null, null, 'center');
    doc.setFontSize(8);
    doc.text('Factura: ' + pedido.id, 2, 35);
    doc.text('Fecha: ' + new Date(pedido.updated_at).toLocaleString(), 2, 40);
    doc.text('Cliente: ' + pedido.cliente.Nombre + ' ' +pedido.cliente.Apellidos , 2, 45);
    doc.text('Vendedor: ' + nombreVendedor, 2, 50);
    doc.line(1, 55, 74, 55);
    doc.text('Producto', 2, 60);
    doc.text('Cantidad', 20, 60);
    doc.text('Vlr Unitario', 40, 60);
    doc.text('Vlr Subtotal', 60, 60);
    doc.line(1, 65, 74, 65);

    productosXPedido.forEach(function(productoPedido, index) {
        totalLinea = totalLinea + 5;
        doc.text(productoPedido.producto.Nombre, 2, totalLinea);
        var subTotal = productoPedido.SubTotal - productoPedido.Descuento;
        if(productoPedido.Descuento > 0 ){
            var longitudNombre = productoPedido.producto.Nombre.length + 9;
            var textoDescuento = "(Descuento: Antes " + productoPedido.SubTotal + " Ahora " + subTotal;
            doc.setFontSize(5);
            doc.text(textoDescuento, longitudNombre, totalLinea);
            doc.setFontSize(8);
        }
        totalLinea = totalLinea + 5;
        doc.text(productoPedido.Cantidad.toString(), 20, totalLinea);
        doc.text(productoPedido.producto.Precio.toString(), 40, totalLinea);
        doc.text(subTotal.toString(), 60, totalLinea);
    });

    totalLinea = totalLinea + 5;
    doc.line(1, totalLinea, 74, totalLinea);
    totalLinea = totalLinea + 5;
    doc.text('Subtotal', 2, totalLinea);
    doc.text(pedido.VentaTotal.toString(), 60, totalLinea);
    totalLinea = totalLinea + 5;
    doc.text('Descuento', 2, totalLinea);
    doc.text(pedido.DescuentoTotal.toString(), 60, totalLinea);
    totalLinea = totalLinea + 5;
    doc.text('Total a pagar', 2, totalLinea);
    doc.text((pedido.VentaTotal - pedido.DescuentoTotal).toString(), 60, totalLinea);
    totalLinea = totalLinea + 5;
    doc.line(1, totalLinea, 74, totalLinea);
    totalLinea = totalLinea + 5;
    doc.text('Formas de pago', doc.internal.pageSize.width/2, totalLinea, null, null, 'center');
    totalLinea = totalLinea + 5;
    doc.line(1, totalLinea, 74, totalLinea);
    totalLinea = totalLinea + 5;
    doc.text('Forma de pago: Contado', 2, totalLinea);
    arregloMediosDepago.forEach(function(medioPago, index) {
        totalLinea = totalLinea + 5;
        doc.text('Medio de pago: '+ medioPago.nombreMedioPago, 2, totalLinea);
    });
    totalLinea = totalLinea + 5;
    doc.text('No estoy obligado a facturar articulo 1.6.1.4.3', doc.internal.pageSize.width/2, totalLinea, null, null, 'center');
    totalLinea = totalLinea + 5;
    doc.text('del decreto 1625 del 1036', doc.internal.pageSize.width/2, totalLinea, null, null, 'center');
    totalLinea = totalLinea + 10;
    doc.text('MUCHAS GRACIAS POR SU COMPRA', doc.internal.pageSize.width/2, totalLinea, null, null, 'center');



    doc.save('factura'+ pedido.id +'.pdf');
    doc.autoPrint({variant: 'non-conform'});
    //window.open(doc.output('bloburl'), '_blank'); NO BORRAR



}

//funcion para pintar la fila del pedido en la que se esta trabajando
function pintarFilaSelecciona(element){
    $(element).closest('tbody').find('tr').removeAttr('style');
    $(element).closest('tr').attr("style","background: #dff0d8");
}


//funcion para habilitar el funcion cuando se se confirmo o se guardo el pedido
function habilitarBtnDeCerrarPedido(){
    $("#BtnCerrarPedido").removeAttr("disabled");
}

//funcion para deshabilitar el funcion cuando se se confirmo o se guardo el pedido
function desHabilitarBtnDeCerrarPedido(){
    $("#BtnCerrarPedido").attr("disabled","disabled");
}

//Funcion para validar si el pedido se esta editando desde el boton de crear pedido
//function validarEdicionDePedidoBtnCrear(element,idFactura){
function validarEdicionDePedidoBtnCrear(){
    if($("#BtnCerrarPedido").is(':disabled')){
        swal({
            title: '¡Un Pedido se esta editando!',
            text: "¿Está seguro que desea descartar los cambios realizados?",
            icon: 'warning',
            buttons: {
                cancel: {
                    text: "Cancelar",
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
                //ObtenerFormCrearPedido(element,idFactura);
               // ObtenerFormCrearPedido();
                guardarPedido(this);
            }
        });
    }else{
       // ObtenerFormCrearPedido(element,idFactura);
        //ObtenerFormCrearPedido();
        guardarPedido(this);
    }
}

function guadarComentario(){
    var comentarioPedido = $("#comentarioPedido").val();
    var idFactura = $("#idPedido").val();
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'guardarComentario/' + idFactura + '/' + comentarioPedido,
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            var stringTdComentarioPedido = '#tdComentarioPedido'+$("#idPedido").val();
            $(stringTdComentarioPedido).html(comentarioPedido);
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

function ActualizarPrecioPedido(element){
    var tr = $(element).closest('tr');
    var elementSubTotal = tr.find("input[name=inputSubttalDtllPedido]").val()
    var valorSuTotal = parseFloat(elementSubTotal) - $(element).val();
    if(valorSuTotal < 0){
        valorSuTotal = 0;
        $(element).val(elementSubTotal)
    }
    tr.find("td[name=tdSubttalDtllPedido]").html('$'+ valorSuTotal);
    var valorTotal = parseFloat($("#lbTotalPedido").text()) - CalcularDescuentoTotal();
    $("#tdTotalPedido").html('$'+ valorTotal);
    $("#tdDescuentos").html('$'+ CalcularDescuentoTotal());
    calcularVuelto();
}

function CalcularDescuentoTotal(){
    var descuentoTotal = 0;
    $("#TablasDetallePedido").find("input[name=inputDescuento]").each(function(ind,row){
        descuentoTotal =  descuentoTotal + parseFloat($(row).val() != ""? $(row).val() : 0);
    });
    return descuentoTotal;
}