var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

//Funcion para cargar la vista para actualizar el inventario
function ajaxRenderSectionActualizarInventario() {
    $.ajax({
        type: 'GET',
        url: urlBase +'actualizarInventario',
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



//Metodo para guarda la informacion del producto retorna la vista con todos los provedores
function GuardarInventario() {
    var form = $("#formInventario");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarInventario',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            swal({
                title: "Transaccción exitosa!",
                text: "El inventario fue actualizado con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            swal({
                title: "Transacción con error!",
                text: "No fue posible actualizar  el inventario!",
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