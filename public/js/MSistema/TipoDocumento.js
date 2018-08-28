var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

//Funcion para cargar la vista de crear tipo documento
function ajaxRenderSectionCrearTipoDocumento() {
    $.ajax({
        type: 'GET',
        url: urlBase +'crearTipoDocumento',
        dataType: 'json',
        success: function (data) {
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

//Metodo para guarda la informacion del tipo de documento y retorna la vista con todos los tipos de documentos
function GuardarTipoDocumento() {
    var form = $("#formTipoDocumento");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarTipoDocumento',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            swal({
                title: "transaccción exitosa!",
                text: "El tipo de documento fue grabado con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el tipo de documento!",
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

//Funcion para mostrar la lista de proveedores
function ajaxRenderSectionListaTiposDocumentos() {
    $.ajax({
        type: 'GET',
        url: urlBase +'tiposDocumentos',
        dataType: 'json',
        success: function (data) {
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