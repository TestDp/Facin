var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP


//Funcion para cargar la vista de crear categoria
function ajaxRenderSectionCrearSede() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearSede',
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

//Metodo para guarda la informacion de la unidad retorna la vista con todas las unidades
function GuardarSede() {
    PopupPosition();
    var form = $("#formSede");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarSede',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "La sede fue grabada con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar la sede!",
                icon: "error",
                button: "OK",
            });
            $("#errorNombre").html("");
            $("#errorDireccion").html("");
            $("#errorTelefono").html("");
            var errors = data.responseJSON;
            if(errors.errors.Nombre){
                var errorNombre = "<strong>"+ errors.errors.Nombre+"</strong>";
                $("#errorNombre").append(errorNombre);}
            if(errors.errors.Direccion){
                var errorDireccion = "<strong>"+ errors.errors.Direccion+"</strong>";
                $("#errorDireccion").append(errorDireccion);}
            if(errors.errors.Telefono){
                var errorTelefono = "<strong>"+ errors.errors.Telefono+"</strong>";
                $("#errorTelefono").append(errorTelefono);}
        }
    });
}

//Funcion para mostrar la lista de categorias
function ajaxRenderSectionListaSedes() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'sedes',
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