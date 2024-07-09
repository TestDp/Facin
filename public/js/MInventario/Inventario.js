var urlBase = ""; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

//Funcion para cargar la vista para actualizar el inventario
function ajaxRenderSectionActualizarInventario() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'actualizarInventario',
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $('#principalPanel').empty().append($(data));
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



//Metodo para guarda la informacion del producto retorna la vista con todos los provedores
function GuardarInventario() {
    var form = $("#formInventario");
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarInventario',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "El inventario fue actualizado con exito!",
                icon: "success",
                button: "OK",
            }).then((value) => {
                form[0].reset();
                $("#Producto_id").val("");
                $("#cantidadActualLabel").html("");
                $("#cantidadFinal").html("");
            });;
            //$('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible actualizar  el inventario!",
                icon: "error",
                button: "OK",
            });
            $("#errorProducto_id").html("");
            $("#errorPrecio").html("");
            $("#errorCantidad").html("");
            $("#errorProveedor_id").html("");
            $("#errorNumFacturaProvedor").html("");

            var errors = data.responseJSON;
            if(errors.errors.Producto_id){
                var errorProducto_id= "<strong>"+ errors.errors.Producto_id+"</strong>";
                $("#errorProducto_id").append(errorProducto_id);}
            if(errors.errors.Precio){
                var errorPrecio = "<strong>"+ errors.errors.Precio+"</strong>";
                $("#errorPrecio").append(errorPrecio);}
            if(errors.errors.Cantidad){
                var errorCantidad = "<strong>"+ errors.errors.Cantidad+"</strong>";
                $("#errorCantidad").append(errorCantidad);}
            if(errors.errors.Proveedor_id){
                var errorProveedor_id = "<strong>"+ errors.errors.Proveedor_id+"</strong>";
                $("#errorProveedor_id").append(errorProveedor_id);}
            if(errors.errors.NumFacturaProvedor){
                var errorNumFacturaProvedor = "<strong>"+ errors.errors.NumFacturaProvedor+"</strong>";
                $("#errorNumFacturaProvedor").append(errorNumFacturaProvedor);}
        }
    });
}


//función para obtener la información de un producto consultada por el id o pk del producto
function ConsultarInfoProducto() {
    var idProducto = $('#Producto_id').val()
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'infoProducto/'+idProducto,
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $("#cantidadActualLabel").html(data.Cantidad);
            $("#CantidadActual").val(data.Cantidad);
            $("#PrecioVenta").val(data.producto.Precio);
            return data.Cantidad;
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

function calcularCantidadFinal() {
    var cantidadActual = parseFloat($("#CantidadActual").val());
    var cantidad = parseFloat($("#Cantidad").val());
    var cantidadFinal = cantidad + cantidadActual;
    $("#cantidadFinal").html(cantidadFinal);
}


//Funcion para mostrar la lista de compras
function ajaxRenderSectionListaCompras() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'compras',
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $('#principalPanel').empty().append($(data));
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

//Funcion para cargar la vista para crear una compra
function ajaxRenderSectionRegistrarCompra() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'registrarCompra',
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $('#principalPanel').empty().append($(data));
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

//funcion para agregar o un producto al tabla productos cuando se esta creando una compra
function agregarProductoCompra() {
    var opcion= $('#Producto').find('option:selected');//obtenemos la opcion seleccionada
    if(opcion.val() !=''){
        if(!buscarProductoSecundario(opcion.val()))
        {
            var tr ='<tr>';
            tr= tr+ '<td><input id="Producto_id" name="Producto_id[]" type="hidden" value="'+opcion.val()+'"/>'+opcion.text()+'</td>'
            tr= tr +'<td><input id="Cantidad" name="Cantidad[]" type="number" class="form-control" onchange="CalcularSubtoltalCompra(this)" onkeyup="CalcularSubtoltalCompra(this)"/></td>'
            tr= tr +'<td><input id="PrecioCompra" name="PrecioCompra[]" type="number" class="form-control"  onchange="CalcularSubtoltalCompra(this)" onkeyup="CalcularSubtoltalCompra(this)"/></td>'
            tr= tr +'<td><input id="PrecioVenta" name="PrecioVenta[]" type="number" class="form-control"  /></td>'
            tr= tr +'<td><h3 id="subtotal" name="subtotal"></h3></td>'
            tr=tr+'<td><a onclick="RemoverProductoCompra(this)"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
            $('#productosSeleccionados').append(tr);

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

//funcion que remueve un producto del panel de productos en la creacion del producto tipo combo
function RemoverProductoCompra(element) {
    $(element).closest('tr').remove();
    MostrarCostoProductoCombo();
}

function CalcularSubtoltalCompra(element){
    var subtotal = $(element).closest('tr').find("input[name^=Cantidad]").val() * $(element).closest('tr').find("input[name^=PrecioCompra]").val();
    $(element).closest('tr').find("h3[name=subtotal]").text(subtotal);
}

//funcion para validar los campos de los productos de la compra
function validarCamposFormCrearProductoCompra()
{

        if(validarCamposDinamicos($('#productosSeleccionados'),'Cantidad','input','*') &&
            validarCamposDinamicos($('#productosSeleccionados'),'PrecioCompra','input','*') )
           // && validarCamposDinamicos($('#productosSeleccionados'),'PrecioVenta','input','*')
        {
            GuardarCompra();
        }else{
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el producto!",
                icon: "error",
                button: "OK",
            });
        }

}

//Metodo para guarda la informacion de la compra
function GuardarCompra() {
    var form = $("#formCompra");
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarCompra',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            $('#principalPanel').empty().append($(data));
            swal({
                title: "Transaccción exitosa!",
                text: "El inventario fue actualizado con exito!",
                icon: "success",
                button: "OK",
            });
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible actualizar  el inventario!",
                icon: "error",
                button: "OK",
            });

            $("#errorProveedor_id").html("");
            $("#errorNumFacturaProvedor").html("");
            var errors = data.responseJSON;
            if(errors.errors.Proveedor_id){
                var errorProveedor_id = "<strong>"+ errors.errors.Proveedor_id+"</strong>";
                $("#errorProveedor_id").append(errorProveedor_id);}
            if(errors.errors.NumFacturaProvedor){
                var errorNumFacturaProvedor = "<strong>"+ errors.errors.NumFacturaProvedor+"</strong>";
                $("#errorNumFacturaProvedor").append(errorNumFacturaProvedor);}
        }
    });
}


function ajaxRenderSectionConsultarCompra(fecha,numFactura){
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'consultarCompra' + '/' + fecha + '/' + numFactura,
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $('#panelPedido').empty().append($(data));
            $('#DetalleCompra').html('Detalle Compra N° ' + numFactura)

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