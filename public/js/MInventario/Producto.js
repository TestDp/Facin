var urlBase = "/Facin/trunk/public/"; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

//Funcion para cargar la vista de crear proveedor
function ajaxRenderSectionCrearProducto() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'crearProducto',
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


//Metodo para guarda la informacion del producto retorna la vista con todos los provedores
function GuardarProducto() {
    var form = $("#formProducto");
    var token = $("#_token").val();
    PopupPosition();
    $.ajax({
        type: 'POST',
        url: urlBase +'guardarProducto',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data:form.serialize(),
        success: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transaccción exitosa!",
                text: "El producto fue grabado con exito!",
                icon: "success",
                button: "OK",
            });
            $('#principalPanel').empty().append($(data));
        },
        error: function (data) {
            OcultarPopupposition();
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el producto!",
                icon: "error",
                button: "OK",
            });
            $("#errorCodigo").html("");
            $("#errorNombre").html("");
            $("#errorPrecio").html("");
            $("#errorPrecioSinIva").html("");
            $("#errorCantidad").html("");
            $("#errorAlmacen_id").html("");
            $("#errorCategoria_id").html("");
            $("#errorUnidadDeMedida_id").html("");
            $("#errorProveedor_id").html("");

            var errors = data.responseJSON;
            if(errors.errors.Codigo){
                var errorCodigo = "<strong>"+ errors.errors.Codigo+"</strong>";
                $("#errorCodigo").append(errorCodigo);}
            if(errors.errors.Nombre){
                var errorNombre = "<strong>"+ errors.errors.Nombre+"</strong>";
                $("#errorNombre").append(errorNombre);}
            if(errors.errors.Precio){
                var errorPrecio = "<strong>"+ errors.errors.Precio+"</strong>";
                $("#errorPrecio").append(errorPrecio);}
            if(errors.errors.PrecioSinIva){
                var errorPrecioSinIva = "<strong>"+ errors.errors.PrecioSinIva+"</strong>";
                $("#errorPrecioSinIva").append(errorPrecioSinIva);}
            if(errors.errors.Cantidad){
                var errorCantidad = "<strong>"+ errors.errors.Cantidad+"</strong>";
                $("#errorCantidad").append(errorCantidad);}
            if(errors.errors.Almacen_id){
                var errorAlmacen_id = "<strong>"+ errors.errors.Almacen_id+"</strong>";
                $("#errorAlmacen_id").append(errorAlmacen_id);}
            if(errors.errors.Categoria_id){
                var errorCategoria_id = "<strong>"+ errors.errors.Categoria_id+"</strong>";
                $("#errorCategoria_id").append(errorCategoria_id);}
            if(errors.errors.UnidadDeMedida_id){
                var errorUnidadDeMedida_id = "<strong>"+ errors.errors.UnidadDeMedida_id+"</strong>";
                $("#errorUnidadDeMedida_id").append(errorUnidadDeMedida_id);}
            if(errors.errors.Proveedor_id){
                var errorProveedor_id = "<strong>"+ errors.errors.Proveedor_id+"</strong>";
                $("#errorProveedor_id").append(errorProveedor_id);}

        }
    });
}


//Funcion para mostrar la lista de categorias
function ajaxRenderSectionListaProductos() {
    PopupPosition();
    $.ajax({
        type: 'GET',
        url: urlBase +'productos',
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

function CalcularPrecioConIva() {
    $("#PrecioConIva").val("");
    precio = parseFloat($("#PrecioSinIva").val()) + (parseFloat($("#PrecioSinIva").val())*0.19);
    $("#PrecioConIva").val(precio);
}