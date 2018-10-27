var urlBase = "";

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};


//Metodo para guarda la informacion del cliente
function GuardarCliente() {

    PopupPosition();
    var form = $("#formCliente");
    var token = $("#_token").val()
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarCliente',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            if(data == true){
                $("#modalCrearCliente").modal('hide');
                $("#formCliente")[0].reset();
              /**  swal({
                    title: "Transaccción exitosa!",
                    text: "El cliente fue grabado con exito!",
                    icon: "success",
                    button: "OK",
                });**/
            }
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el cliente!",
                icon: "error",
                button: "OK",
            });
            $("#errorNombre").html("");
            $("#errorApellidos").html("");
            $("#errorIdentificacion").html("");
            $("#errorTelefono").html("");
            $("#errorCorreoElectronico").html("");
            var errors = data.responseJSON;
            if(errors.errors.Nombre){
                var errorNombre = "<strong>"+ errors.errors.Nombre+"</strong>";
                $("#errorNombre").append(errorNombre);}
            if(errors.errors.Apellidos){
                var errorApellidos = "<strong>"+ errors.errors.Apellidos+"</strong>";
                $("#errorApellidos").append(errorApellidos);}
            if(errors.errors.Identificacion){
                var errorIdentificacion = "<strong>"+ errors.errors.Identificacion+"</strong>";
                $("#errorIdentificacion").append(errorIdentificacion);}
            if(errors.errors.Telefono){
                var errorTelefono = "<strong>"+ errors.errors.Telefono+"</strong>";
                $("#errorTelefono").append(errorTelefono);}
            if(errors.errors.CorreoElectronico){
                var errorCorreoElectronico = "<strong>"+ errors.errors.CorreoElectronico+"</strong>";
                $("#errorCorreoElectronico").append(errorCorreoElectronico);}
        }
    });
}