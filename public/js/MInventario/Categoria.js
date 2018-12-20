var urlBase = ""; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

//Funcion para cargar la vista de crear categoria
function ajaxRenderSectionCrearCategoria() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearCategoria',
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

//Funcion para cargar la vista de editar categoria
function ajaxRenderSectionEditarCategoria() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'editarCategoria',
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

//Metodo para guarda la informacion de la categoria y retorna la vista con todos las categorias
function GuardarCategoria() {
    PopupPosition();
    var form = $("#formCategoria");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarCategoria',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "La categoria fue grabada con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar la categoria!",
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

//Funcion para mostrar la lista de categorias
function ajaxRenderSectionListaCategorias() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'categorias',
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