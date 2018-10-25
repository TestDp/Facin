var urlBase = "";

try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

function guardarEquivalencia(element,idProducto)
{
    var contenedorDivModal = $(element).closest('div[name=modalCrearEquivalencia]');
    var idProductoS = contenedorDivModal.find('select[name=ListaProductos]').val();
    var cantidad = contenedorDivModal.find('input[name=cantidad]').val();
    var respuestaIdProducto = validarCampoSelect(contenedorDivModal.find('select[name=ListaProductos]'));
    var respuestaCantidad = validarCamposDinamicos(contenedorDivModal,'cantidad','input','*');
    if(respuestaIdProducto &&  respuestaCantidad){
        var bodyTabla = contenedorDivModal.find('tbody[name=bodytablaEquivalencias]');
        $.ajax({
            type: 'GET',
            url: urlBase +'guardarEquivalencia/'+ idProducto + '/' +idProductoS + '/' + cantidad,
            dataType: 'json',
            success: function (data) {
                var tr ='<tr>';
                tr = tr + '<td scope="col">'+ data.ProductoPpal.Nombre +'</td>';
                tr = tr + '<td scope="col">('+ data.ProductoPpal.unidad_de_medida.Abreviatura+')'+data.ProductoPpal.unidad_de_medida.Unidad+'</td>';
                tr = tr + '<td scope="col">'+ data.ProductoSec.Nombre +'</td>';
                tr = tr + '<td scope="col">('+ data.ProductoSec.unidad_de_medida.Abreviatura+')'+data.ProductoSec.unidad_de_medida.Unidad+'</td>';
                tr = tr + '<td scope="col">'+ cantidad +'</td>';
                tr = tr +'<td scope="col"><button type="button" class="btn btn-default" aria-label="Left Align" title="Eliminar equivalencias"\n' +
                    '                                                    data-toggle="modal" data-target="#modalCrearEquivalencia{{$producto->Producto->id}}"\n' +
                    '                                                onclick="ElimiarEquivalenciasProducto(this,'+idProducto+','+ idProductoS +')">\n' +
                    '                                                <span class="glyphicon glyphicon-remove" aria-hidden="true" ></span>\n' +
                    '                                            </button></td>';
                tr = tr +'</tr>';
                bodyTabla.append(tr);
                contenedorDivModal.find('select[name=ListaProductos]').val("");
                contenedorDivModal.find('input[name=cantidad]').val("");
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

}

function obtenerStringUnidad(element) {
    var nombreUnidad = $(element).find('option:selected').data('title');
    $(element).closest('div[name=modalCrearEquivalencia]').find('div[name=divUdSecundario]').html(nombreUnidad);
}

function ObtenerEquivalenciasProducto(element,idProducto){
    var contenedorDivModal = $(element).closest('tr');
    var bodyTabla = contenedorDivModal.find('tbody[name=bodytablaEquivalencias]');
    $.ajax({
        type: 'GET',
        url: urlBase +'equivalenciasProducto/'+ idProducto,
        dataType: 'json',
        success: function (data) {
            bodyTabla.html("");
            $.each(data, function (i,equivalencia) {
                var tr ='<tr>';
                tr = tr + '<td scope="col">'+ equivalencia.producto_principal.Nombre +'</td>';
                tr = tr + '<td scope="col">('+ equivalencia.producto_principal.unidad_de_medida.Unidad+')'+equivalencia.producto_principal.unidad_de_medida.Unidad+'</td>';
                tr = tr + '<td scope="col">'+ equivalencia.producto_secundario.Nombre +'</td>';
                tr = tr + '<td scope="col">('+ equivalencia.producto_secundario.unidad_de_medida.Unidad+')'+equivalencia.producto_secundario.unidad_de_medida.Unidad+'</td>';
                tr = tr + '<td scope="col">'+ equivalencia.Cantidad +'</td>';
                tr = tr +'<td scope="col"><button type="button" class="btn btn-default" aria-label="Left Align" title="Eliminar equivalencias"\n' +
                    '                                                    data-toggle="modal" data-target="#modalCrearEquivalencia{{$producto->Producto->id}}"\n' +
                    '                                                onclick="ElimiarEquivalenciasProducto(this,'+idProducto+','+equivalencia.producto_secundario.id+')">\n' +
                    '                                                <span class="glyphicon glyphicon-remove" aria-hidden="true" ></span>\n' +
                    '                                            </button></td>';
                tr = tr +'</tr>';
                bodyTabla.append(tr);
            });
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

function ElimiarEquivalenciasProducto(element,idProductoP,idProductos) {
    var tr = $(element).closest('tr');
    $.ajax({
        type: 'GET',
        url: urlBase +'eliminarEquivalencia/'+  idProductoP + '/' +idProductos,
        dataType: 'json',
        success: function (data) {
            if(data){
                tr.remove();
            }
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

function validarCampoSelect(select){

    var label = select.closest('div[name=divLisProductos]').find('label[name=errorProductosList]');
    if(select.val() == ""){
        label.html("El campo es obligatorio");
        return false;
    }else{
        label.html("");
        return true;
    }
}