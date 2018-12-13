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
            var tr = '<tr style="background: #dff0d8">';
            tr = tr +'<td scope="col">'+data.Pedido.id +'</td>';
            tr = tr +'<td scope="col">'+data.Pedido.created_at+'</th>';
            tr = tr +'<td scope="col">'+data.Pedido.estado_factura.Nombre+'</td>';
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

/**funcion para validar la disponibildiad del producto
function validarDisponibilidad(){
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
                agregarProductoPedido();
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
}**/

//funcion para agregar un producto al pedido
function agregarProductoPedido() {
    var opcion= $('#Producto_id').find('option:selected');//obtenemos la opcion seleccionada
    if(opcion.val() !=''){
        if(!buscarProductoSecundario(opcion.val()))
        {
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
        row = row + '<input id="ProductoSecundario_id" name="ProductoSecundario_id" type="hidden" value="'+opcion.val()+'"/>';
        row = row + '<button class="btn boton-menos" type="button"><span class="glyphicon glyphicon-minus" onclick="restarCantidadProductoPedido(this)"></span></button>';
        row = row + '<label class="cantidad" id="lbCantidad" name="lbCantidad">1</label>';
        row = row + '<button class="btn boton-mas" type="button"><span class="glyphicon glyphicon-plus" onclick="sumarCantidadProductoPedido(this)"></span></button></td>';
        row = row + '<td><label class="nombre-producto"><p class="nombre-pedido-p">'+opcion.data('title')+'</p></label></td>';
        row = row + '<td><span class="glyphicon glyphicon-usd"></span>';
        row = row + '<label class="precio-pedido" id="lbTotal">'+opcion.data('num')+'</label></td>';
        row = row + '<td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-comment"></span></button></td>';
        row = row + '<td><button class="extras-pedido" type="button"><span class="glyphicon glyphicon-remove" onclick="removerProductoPedido(this)"></span></button></td>';
        row = row + '</tr>';
    $('#tablaProductosSeleccionados').append(row);
}

//fucntion para sumar 1 a la cantidad del producto del pedido
function sumarCantidadProductoPedido(element) {
    var row = $(element).closest("tr[name=rowPrducto]");
    var label = row.find("label[name=lbCantidad]");
    var labelCantidad = row.find("label[name=lbCantidad]").text();
    label.html(parseInt(labelCantidad) + 1);
}

//fucntion para restar 1 a la cantidad del producto del pedido
function restarCantidadProductoPedido(element) {
    var row = $(element).closest("tr[name=rowPrducto]");
    var label = row.find("label[name=lbCantidad]");
    var labelCantidad = row.find("label[name=lbCantidad]").text();
    label.html(parseInt(labelCantidad) - 1);
}

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
        }
    })
}

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
            if(data.Respuesta){
                swal({
                    title: "Transaccción exitosa!",
                    text: "El pedido fue confirmado con exito!",
                    icon: "success",
                    button: "OK",
                });
                var stringTdtotalPedido = '#tdTotalPedido'+$("#idPedido").val()
                $(stringTdtotalPedido).html("$"+data.PrecioTotal);
                $('#panelPedido').empty();

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

function editarPedido(idFactura) {
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