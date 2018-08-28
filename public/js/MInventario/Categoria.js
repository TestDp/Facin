var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

//Funcion para cargar la vista de crear categoria
function ajaxRenderSectionCrearCategoria() {
    $.ajax({
        type: 'GET',
        url: urlBase +'crearCategoria',
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

//Metodo para guarda la informacion de la categoria y retorna la vista con todos las categorias
function GuardarCategoria() {
    var form = $("#formCategoria");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarCategoria',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            swal({
                title: "Transaccción exitosa!",
                text: "La categoria fue grabada con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar la categoria!",
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
function ajaxRenderSectionListaCategorias() {
    $.ajax({
        type: 'GET',
        url: urlBase +'categorias',
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