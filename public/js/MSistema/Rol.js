var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

//Funcion para cargar la vista de crear un rol
function ajaxRenderSectionCrearRol() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearRol',
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
function GuardarRol() {
    PopupPosition();
    var form = $("#formRol");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarRol',
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
function ajaxRenderSectionListaRoles() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'roles',
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

function checkRecursosHijos(element){
    if($(element).prop( "checked" )) {
        $(element).closest('li[name=liPadre]').find('input[name*=idRecurso]').each(function (ind, check) {
            if (!$(check).prop("checked")) {
                $(check).prop("checked", "checked")
            }
        });
    }else{
        $(element).closest('li[name=liPadre]').find('input[name*=idRecurso]').each(function (ind, check) {
            $(check).prop("checked", false);
        });
    }
}

function checkRecursoPadre(element){
    if($(element).prop( "checked")) {
        $(element).closest('li[name=liPadre]').children('input[name*=idRecurso]').each(function (ind, check) {
                $(check).prop("checked", "checked");
        });
    }else{
        var respuesta = true;
        $(element).closest('ul[name=ulhijo]').find('input[name*=idRecurso]').each(function (ind, check) {
            if ($(check).prop("checked")) {
                respuesta = false;
            }

        });
        if(respuesta){
            $(element).closest('li[name=liPadre]').children('input[name*=idRecurso]').prop("checked",false);
        }
    }
}