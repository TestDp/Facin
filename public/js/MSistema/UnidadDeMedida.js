var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

//Funcion para cargar la vista de crear tipo documento
function ajaxRenderSectionCrearUnidad() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearUnidad',
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
function GuardarUnidad() {
    PopupPosition();
    var form = $("#formUnidad");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarUnidad',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "La unidad de medidad fue grabada con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar la unidad de medida!",
                icon: "error",
                button: "OK",
            });
            $("#errorUnidad").html("");
            $("#errorAbreviatura").html("");
            $("#errorDescripcion").html("");
            var errors = data.responseJSON;
            if(errors.errors.Unidad){
                var errorUnidad = "<strong>"+ errors.errors.Unidad+"</strong>";
                $("#errorUnidad").append(errorUnidad);}
            if(errors.errors.Abreviatura){
                var errorAbreviatura = "<strong>"+ errors.errors.Abreviatura+"</strong>";
                $("#errorAbreviatura").append(errorAbreviatura);}
            if(errors.errors.Descripcion){
                var errorDescripcion = "<strong>"+ errors.errors.Descripcion+"</strong>";
                $("#errorDescripcion").append(errorDescripcion);}
        }
    });
}

//Funcion para mostrar la lista de unidades
function ajaxRenderSectionListaUnidades() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'unidades',
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
