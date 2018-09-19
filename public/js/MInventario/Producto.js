var urlBase = ""; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

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

//funcion para validar los campos espcialmente los dinamicos
function validarCamposFormCrearProducto()
{
    if( $('#EsCombo').prop( "checked" ))//Preguntamos si el checkbo EsCombo esta seleccionado para eliminar el contenido para que no se vaya en request
    {
        if(validarCamposDinamicos($('#productosSeleccionados'),'Cantidad','input','*'))
        {
            $("#divProveedores").html('');
            GuardarProducto();
        }else{
            swal({
                title: "Transacción con error!",
                text: "No fue posible grabar el producto!",
                icon: "error",
                button: "OK",
            });
        }

    }
    else{
        $("#divProductos").html('');
        GuardarProducto();
    }
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
            $("#errorTipoDeProducto_id").html("");
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
            if(errors.errors.TipoDeProducto_id){
                var errorTipoDeProducto_id = "<strong>"+ errors.errors.TipoDeProducto_id+"</strong>";
                $("#errorTipoDeProducto_id").append(errorTipoDeProducto_id);}
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

//Funcion para calcualr el precion con iva tomar el valor del campo precio sin iva o costo
function CalcularPrecioConIva() {
    $("#PrecioConIva").val("");
    precio = parseFloat($("#PrecioSinIva").val()) + (parseFloat($("#PrecioSinIva").val())*0.19);
    $("#PrecioConIva").val(precio);
}

//funcion para agregar o un producto al tabla productos cuando se esta creando un producto tipo combo
function agregarProducto() {
    var opcion= $('#ListaProductos').find('option:selected');//obtenemos la opcion seleccionada
    if(opcion.val() !=''){
        if(!buscarProductoSecundario(opcion.val()))
        {
            var tr ='<tr>';
            tr= tr+ '<td><input id="ProductoSecundario_id" name="ProductoSecundario_id[]" type="hidden" value="'+opcion.val()+'"/>'+opcion.text()+'</td>'
            tr= tr +'<td><input id="Cantidad" name="Cantidad[]" type="number" class="form-control" data-num="'+opcion.data('num')+'" onkeyup="MostrarCostoProductoCombo()"/></td>'
            tr=tr+'<td><a onclick="RemoverProducto(this)"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
            $('#productosSeleccionados').append(tr);

        }else{
            swal({
                title: "Operación incorrecta!",
                text: "El producto ya fue seleccionado!",
                icon: "error",
                button: "OK",
            });
        }
    }
}

//funcio que permite ocultar o mostrar el panel de productos si se va a crear o no un producto tipo combo
function mostrarYOcultarPanelAgregarProductos() {
    if( $('#EsCombo').prop( "checked" ))//Preguntamos si el checkbo EsCombo esta seleccionado para mostrar o ocultar el panel de productos
    {
        $("#divProveedores").attr('hidden','hidden');
        $("#divProductos").removeAttr('hidden');
    }
    else{
        $("#divProductos").attr('hidden','hidden');
        $("#divProveedores").removeAttr('hidden');
    }
}

//funcion que remueve un producto del panel de productos en la creacion del producto tipo combo
function RemoverProducto(element) {
    $(element).closest('tr').remove();
    MostrarCostoProductoCombo();
}

//funcion para mostrar el costro de un producto en combo
function MostrarCostoProductoCombo() {
    var costoProductoCombo =0;
    $("#productosSeleccionados").find('input[name*=Cantidad]').each(function (ind, input) {
        costoProductoCombo = costoProductoCombo + CalcularCostoProductoCombo($(input).data('num'),$(input).val());
    });
    $("#PrecioSinIva").val(costoProductoCombo);
    CalcularPrecioConIva();
}

//funcion para calcualr el costo de un producto en cambo, se calcula con el costo de los productos que lo comforman
function CalcularCostoProductoCombo(costosProducto,cantidad) {
    var costoProducto = costosProducto*cantidad;
    return costoProducto;
}

//funcion que busca el prodcuto y  retornar verdadero si el producto ya fue seleccionado en caso contrario retorna falso
function buscarProductoSecundario(idprodcuto){
    var respuesta = false;
    $("#productosSeleccionados").find('input[name*=ProductoSecundario_id]').each(function (ind, input) {
        if(idprodcuto == $(input).val())
            respuesta = true;
    });
    return respuesta;
}

