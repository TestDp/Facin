var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

//Funcion para cargar la vista de crear proveedor
function ajaxRenderSectionCrearProducto() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearProducto',
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $('#principalPanel').empty().append($(data));
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


//Metodo para guarda la informacion del producto retorna la vista con todos los provedores
function GuardarProducto() {
    var form = $("#formProducto");
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarProducto',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "El producto fue grabado con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el producto!",
                icon: "error",
                button: "OK",
            });
            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
        }
    });
}


//Funcion para mostrar la lista de categorias
function ajaxRenderSectionListaProductos() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'productos',
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $('#principalPanel').empty().append($(data));
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

function CalcularPrecioConIva() {
    $("#PrecioConIva").val("");
    precio = parseFloat($("#PrecioSinIva").val()) + (parseFloat($("#PrecioSinIva").val())*0.19);
    $("#PrecioConIva").val(precio);
}