var urlBase = ""; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

//Funcion para cargar la vista de crear categoria
function ajaxRenderSectionCrearAlmacen() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearAlmacen',
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

//Funcion para cargar la vista de crear categoria
function ajaxRenderSectionVistaEditarAlmacen(idAlmacen) {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'editarAlmacen/'+idAlmacen,
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

//Metodo para guarda la informacion del almacen  y retorna la vista con todos los almacenes
function GuardarAlmacen() {
    var form = $("#formAlmacen");
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarAlmacen',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "El almacen fue grabado con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el almacen!",
                icon: "error",
                button: "OK",
            });
            var errors = data.responseJSON;
            $("#errorNombre").html("");
            $("#errorUbicacion").html("");
            $("#errorSede_id").html("");
            var errors = data.responseJSON;
            if(errors.errors.Nombre){
                var errorNombre = "<strong>"+ errors.errors.Nombre+"</strong>";
                $("#errorNombre").append(errorNombre);}
            if(errors.errors.Ubicacion){
                var errorUbicacion = "<strong>"+ errors.errors.Ubicacion+"</strong>";
                $("#errorUbicacion").append(errorUbicacion);}
            if(errors.errors.Sede_id){
                var errorSede_id = "<strong>"+ errors.errors.Sede_id+"</strong>";
                $("#errorSede_id").append(errorSede_id);}
        }
    });
}

//Funcion para mostrar la lista de categorias
function ajaxRenderSectionListaAlmacenes() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'almacenes',
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