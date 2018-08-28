var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

//Funcion para cargar la vista de crear categoria
function ajaxRenderSectionCrearAlmacen() {
    $.ajax({
        type: 'GET',
        url: urlBase +'crearAlmacen',
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

//Metodo para guarda la informacion del almacen  y retorna la vista con todos los almacenes
function GuardarAlmacen() {
    var form = $("#formAlmacen");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarAlmacen',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            swal({
                title: "Transaccción exitosa!",
                text: "El almacen fue grabado con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el almacen!",
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
function ajaxRenderSectionListaAlmacenes() {
    $.ajax({
        type: 'GET',
        url: urlBase +'almacenes',
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