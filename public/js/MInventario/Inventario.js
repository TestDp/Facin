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
            });
            $('#principalPanel').empty().append($(data));
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