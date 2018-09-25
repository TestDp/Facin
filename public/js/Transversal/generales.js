//funcion para obtener la url en al cual se esta ejecuntando la aplicación
function obtenerUlrBase() {
    var rootFolder = "";
    switch (document.location.hostname) {
        case 'facin.co':
            rootFolder = '/'; break;
        case 'localhost':
            rootFolder = '/Facin/trunk/public/'; break;
        default:  // set whatever you want
    }
    var urlBase = location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '') + rootFolder;
    return urlBase;
};


//Muestra los divs que se utilizan para mostrar
//el efecto de espera en una petición ajax.
function PopupPosition() {
    var topLoading = $(window).scrollTop() + ($(window).height() / 2);
    var leftLoading = $(window).scrollLeft() + ($(window).width() / 2);
    //$("#capa_loading").css({ "top": $(window).scrollTop() }).show();
    $("#capa_loading").show();
    $("#_loading").css({ "top": topLoading, "left": leftLoading }).show();
}

//Oculta los divs que se utilizan para mostrar
//el efecto de espera en una petición ajax.
function OcultarPopupposition() {
    $("#capa_loading").hide();
    $("#_loading").hide();
}



//contenedor: contenedor donde se encuentran los campos dinamicos a validar ejemplo $("#actividades")
//nameElementoAValidar: nombre(name) de los elementos a validar ejemplo "DescripcionActividad"
//tipoElemento:tipo de elemento a buscar para realizar la validacion por ejemplo "input"
//tipoSelector: es el tipo de selector para jquery un ejemplo es el asterisco(*) es el que encuentra todos elementos que contengan un subestring especificada,
//sino se especifica un selector se toma el igual como defecto..consultar api de jquery https://api.jquery.com/category/selectors/
//errorClass:es la clase con la que va aparecer la etiqueta que mostrara el mensaje de validación por defecto viene con la clase "error-dinamico".
//errorMensaje: mensaje que se mostrará de la validación el mensaje por defecto es "el campo es obligatorio"
function validarCamposDinamicos(contenedor, nameElementoAValidar, tipoElemento,tipoSelector, errorClass,errorMensaje) {

    if (contenedor != undefined && nameElementoAValidar != undefined)
    {
        var formulario = $(contenedor);

        var stringElementoBuscar = "";
        if (tipoSelector != undefined)
        {
            stringElementoBuscar = tipoElemento + "[name" + tipoSelector + "=" + nameElementoAValidar + "]";
        } else
        {
            stringElementoBuscar = tipoElemento + "[name=" + nameElementoAValidar + "]";
        }

        var valido = true;
        var labelError="";
        if (errorClass === undefined && errorMensaje === undefined)
        {
            labelError = '<label class="error-dinamico">El campo es obligatorio</label>';
        } else if (errorClass != undefined && errorMensaje === undefined)
        {
            labelError = '<label class="' + errorClass + '">El campo es obligatorio</label>';
        } else if (errorClass != undefined && errorMensaje != undefined)
        {
            labelError = '<label class="' + errorClass + '">' + errorMensaje + '</label>';
        } else if (errorClass === undefined && errorMensaje != undefined)
        {
            labelError = '<label class="error-dinamico">' + errorMensaje + '</label>';
        }

        formulario.find(stringElementoBuscar).each(function (ind,element) {
            var label = $(element).next("label");
            if ($(element).val().trim() === '') {
                if (label != undefined) {
                    label.remove();
                }
                $(element).after(labelError);
                $(element).attr("onchange", "quitarlabelError(this)");
                valido = false;
            } else
            {
                label.remove();
            }
        })
        return valido;
    } else {
        return false;
    }


}

//funcion para quitar las etiquetas de la validación dimamica
function quitarlabelError(element)
{
    var label = $(element).next("label");
    if ($(element).val().trim() === '') {
        if (label != undefined) {
            label.remove();
        }
    } else {
        label.remove();
    }

}