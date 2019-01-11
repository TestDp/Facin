var urlBase = ""; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

//Funcion para cargar la vista de crear tipo documento
function ajaxRenderSectionCrearTipoProducto() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearTipoProducto',
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

//Funcion para cargar la vista de editar tipo documento
function ajaxRenderSectionEditarTipoProducto(idTipo) {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'editarTipoProducto/' + idTipo,
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

//Metodo para guarda la informacion de la categoria y retorna la vista con todos las categorias
function GuardarTipoProducto() {
    PopupPosition();
    var form = $("#formTipoProducto");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarTipoProducto',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "El tipo de producto fue grabado con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el tipo de producto!",
                icon: "error",
                button: "OK",
            });
            $("#errorNombre").html("");
            $("#errorDescripcion").html("");
            var errors = data.responseJSON;
            if(errors.errors.Nombre){
                var errorNombre = "<strong>"+ errors.errors.Nombre+"</strong>";
                $("#errorNombre").append(errorNombre);}
            if(errors.errors.Descripcion){
                var errorDescripcion = "<strong>"+ errors.errors.Descripcion+"</strong>";
                $("#errorDescripcion").append(errorDescripcion);}
        }
    });
}


//Funcion para mostrar la lista de proveedores
function ajaxRenderSectionListaTiposProductos() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'tiposProductos',
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