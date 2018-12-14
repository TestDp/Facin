var urlBase = ""; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

//Funcion para cargar la vista de crear proveedor
function ajaxRenderSectionCrearProveedor() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearProveedor',
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

//Funcion para cargar la vista de editar proveedor
function ajaxRenderSectionEditarProveedor(idProveedor) {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'editarProveedor/' + idProveedor,
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



//Metodo para guarda la informacion del proveedores y retorna la vista con todos los provedores
function GuardarProveedor() {
    var form = $("#formProveedor");
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarProveedor',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "El proveedor fue grabado con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el proveedor!",
                icon: "error",
                button: "OK",
            });
            $("#errorNombre").html("");
            $("#errorApellidos").html("");
            $("#errorNit").html("");
            $("#errorIdentificacion").html("");
            $("#errorCorreoElectronico").html("");
            $("#errorTelefono").html("");
            $("#errorCelular").html("");
            $("#errorTerminos_De_Pago").html("");
            $("#errorTipoDocumento_id").html("");
            $("#errorRazonSocial").html("");
            $("#errorDescripcion").html("");
            var errors = data.responseJSON;
            if(errors.errors.Nombre){
                var errorNombre = "<strong>"+ errors.errors.Nombre+"</strong>";
                $("#errorNombre").append(errorNombre);}
            if(errors.errors.Apellidos){
                var errorApellidos = "<strong>"+ errors.errors.Apellidos+"</strong>";
                $("#errorApellidos").append(errorApellidos);}
            if(errors.errors.Nit){
                var errorNit = "<strong>"+ errors.errors.Nit+"</strong>";
                $("#errorNit").append(errorNit);}
            if(errors.errors.Identificacion){
                var errorIdentificacion = "<strong>"+ errors.errors.Identificacion+"</strong>";
                $("#errorIdentificacion").append(errorIdentificacion);}
            if(errors.errors.CorreoElectronico){
                var errorCorreoElectronico = "<strong>"+ errors.errors.CorreoElectronico+"</strong>";
                $("#errorCorreoElectronico").append(errorCorreoElectronico);}
            if(errors.errors.Telefono){
                var errorTelefono = "<strong>"+ errors.errors.Telefono+"</strong>";
                $("#errorTelefono").append(errorTelefono);}
            if(errors.errors.Celular){
                var errorCelular = "<strong>"+ errors.errors.Celular+"</strong>";
                $("#errorCelular").append(errorCelular);}
            if(errors.errors.Terminos_De_Pago){
                var errorTerminos_De_Pago = "<strong>"+ errors.errors.Terminos_De_Pago+"</strong>";
                $("#errorTerminos_De_Pago").append(errorTerminos_De_Pago);}
            if(errors.errors.TipoDocumento_id){
                var errorTipoDocumento_id = "<strong>"+ errors.errors.TipoDocumento_id+"</strong>";
                $("#errorTipoDocumento_id").append(errorTipoDocumento_id);}
            if(errors.errors.RazonSocial){
                var errorRazonSocial = "<strong>"+ errors.errors.RazonSocial+"</strong>";
                $("#errorRazonSocial").append(errorRazonSocial);}
            if(errors.errors.Descripcion){
                var errorDescripcion = "<strong>"+ errors.errors.Descripcion+"</strong>";
                $("#errorDescripcion").append(errorDescripcion);}
        }
    });
}

//Funcion para mostrar la lista de proveedores
function ajaxRenderSectionListaProveedores() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'proveedores',
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