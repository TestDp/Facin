var urlBase = ""; //SE DEBE VALIDAR CUAL ES LA URL EN LA QUE SE ESTA CORRIENDO LA APP
var arrayColores= ["#6FBEEE","#0000CC","#003300","#0033FF","#006600","#006699",
    "#0066CC","#009966","#009999","#0099CC","#0099FF","#00CC99","#00CCCC","#00CCFF","#00FF00","#00FF33",
    "#00FF66","#00FF99","#330033","#330066","#330099","#3300CC","#3300FF","#333300","#333333","#333366","#333399","#3333CC","#3333FF",
    "#336600","#336633","#336666","#336699","#3366CC","#3366FF","#339900","#339933","#339966","#339999","#3399CC","#3399FF","#33CC00","#33CC33","#33CC66","#33CC99",
    "#66FF33","#66FF66","#66FF99","#66FFCC","#99CC00","#99CC33","#99CC66","#99FF00","#99FF33","#99FF66",
    "#99FF99","#99FFCC","#99FFFF","#CC0000","#CC00CC","#CC00FF","#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF","#CC6600",
    "#CC6633","#FF0066","#FF0099","#FF00CC","#FF00FF","#FF3300","#FF3333","#FF3366","#FF3399","#FF33CC","#FF33FF","#FF6600","#FF6633","#FF6666","#FF6699","#FF66CC",
    "#FF66FF","#FF9900","#FF9933","#FF9966","#FF9999"];
try {
    urlBase = obtenerUlrBase();
} catch (e) {
    console.error(e.message);
    throw new Error("El modulo transversales es requerido");
};

//Funcion para cargar la vista de visualizar el informe diario
function ajaxRenderSectionVisualizarInformeDarios(fechaFiltro) {
    PopupPosition();
    var fecha = fechaFiltro ? fechaFiltro:getFechaActual();
    $.ajax({
        type: 'GET',
        url: urlBase +'ObtenerVistaInformeDiario/' + fecha,
        dataType: 'json',
        success: function (data) {
            OcultarPopupposition();
            $('#principalPanel').empty().append($(data));
            $("#filtrofechaActual").val(fecha);
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



//Funcion para cargar la vista de visualizar el informe por rango de fechas
function ajaxRenderSectionVisualizarXRangoFechas(fechaFiltroInicial, fechaFiltroFechaFinal) {
    PopupPosition();
    var fechaFiltroInicial = fechaFiltroInicial ? fechaFiltroInicial:getFechaActual();
    var fechaFiltroFechaFinal = fechaFiltroFechaFinal ? fechaFiltroFechaFinal:getSumarDiasFecha(fechaFiltroInicial,7);
    $.ajax({
        type: 'GET',
        url: urlBase +'ObtenerVistaInformeXFechas/' + fechaFiltroInicial + '/' + fechaFiltroFechaFinal,
        dataType: 'json',
        success: function (data) {
            $('#principalPanel').empty().append($(data.vista));
            $("#filtrofechaInicio").val(fechaFiltroInicial);
            $("#filtrofechaFinal").val(fechaFiltroFechaFinal);
            var total = data.totalVenta > data.totalGasto ? data.totalVenta : data.totalGasto;
            construirGraficoVentasXFecha(fechaFiltroInicial,fechaFiltroFechaFinal,data.mediosPago,data.ventasXfechasXMDD,total,data.gastosProveedorXFecha);
            OcultarPopupposition();
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

function ajaxRenderSectionVisualizarVentasXProducto(fechaFiltroInicial, fechaFiltroFechaFinal){
    PopupPosition();
    var fechaFiltroFechaFinal = fechaFiltroFechaFinal ? fechaFiltroFechaFinal:getFechaActual();
    var fechaFiltroInicial = fechaFiltroInicial ? fechaFiltroInicial:getRestarDiasFecha(fechaFiltroFechaFinal,7);
    
    $.ajax({
        type: 'GET',
        url: urlBase +'ObtenerVistaVentasXProducto/' + fechaFiltroInicial + '/' + fechaFiltroFechaFinal,
        dataType: 'json',
        success: function (data) {
            $('#principalPanel').empty().append($(data.vista));
            $("#filtrofechaInicio").val(fechaFiltroInicial);
            $("#filtrofechaFinal").val(fechaFiltroFechaFinal);
            construirGraficoVentasXProducto(data.ventasXProducto);
            OcultarPopupposition();
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


function getFechaActual(){
    var fecha =  new Date(Date.now());
    var anio = fecha.getFullYear() ;
    var mes = fecha.getMonth().toString().length == 1? '0' + (fecha.getMonth() + 1) : fecha.getMonth();
    var dia = fecha.getDate().toString().length == 1 ? '0' + fecha.getDate() : fecha.getDate();
    return anio + '-' +  mes + '-' + dia;
}

function getSumarDiasFecha(fecha,days){
    var fecha =  new Date(fecha);
    fecha.setDate(fecha.getDate() + days);
    var anio = fecha.getFullYear() ;
    var mes = fecha.getMonth().toString().length == 1? '0' + (fecha.getMonth() + 1) : fecha.getMonth();
    var dia = fecha.getDate().toString().length == 1 ? '0' + fecha.getDate() : fecha.getDate();
    return anio + '-' +  mes + '-' + dia;
}

function getRestarDiasFecha(fecha,days){
    var fecha =  new Date(fecha);
    fecha.setDate(fecha.getDate() - days);
    var anio = fecha.getFullYear() ;
    var mes = fecha.getMonth().toString().length == 1? '0' + (fecha.getMonth() + 1) : fecha.getMonth();
    var dia = fecha.getDate().toString().length == 1 ? '0' + fecha.getDate() : fecha.getDate();
    return anio + '-' +  mes + '-' + dia;
}

function construirGraficoVentasXFecha(fechaInicial,fechaFinal,mediosPago,ventasXfecha,total,gastosProveedorXFecha) {
    var arrayLabelFechas = new Array();
    var fechaN = fechaInicial;
    arrayLabelFechas.push(fechaN);
    var ind = 2;
    while(fechaN < fechaFinal){
        fechaN = getSumarDiasFecha(fechaInicial,ind);
        arrayLabelFechas.push(fechaN);
        ind++;
    }

    var arrayValoresVentas = new Array();
    var arrayValoresGastos = new Array();
    arrayLabelFechas.forEach(function(labelFecha) {
        var ventaXfecha = ventasXfecha.find(ventaXfecha => ventaXfecha.created_at === labelFecha);
        var gastoProveedorXFecha = gastosProveedorXFecha.find(gastoXfecha => gastoXfecha.created_at === labelFecha);
        if(ventaXfecha){
            arrayValoresVentas.push(ventaXfecha.Total);
        }else{
            arrayValoresVentas.push(0);
        }
        if(gastoProveedorXFecha){
            arrayValoresGastos.push(gastoProveedorXFecha.Total);
        }else{
            arrayValoresGastos.push(0);
        }

    });
/*   var  nombreMedioPago = mediosPago.map(medio => {
                return medio.Nombre;
    });*/
/*   var valorXfecha = ventasXfecha.map(ventaXfecha => {
       return ventaXfecha.Total;
   });*/
/*    var fechas = ventasXfecha.map(ventaXfecha => {
        return ventaXfecha.created_at;
    });*/

var ctx = document.getElementById("ventasXfecha");
var data = {
    labels: arrayLabelFechas,
    datasets: [
        {
            data:arrayValoresVentas,
            label: "Ventas",
            backgroundColor: arrayColores
        },
        {
            data:arrayValoresGastos,
            label: "Gastos",
            backgroundColor: arrayColores
        }
    ]


}
var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        title: {
            display: true,
            text: 'Ventas y gastos por dia',
            top: 'bottom',
            fontSize: 12
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    min: 0,
                    max: parseInt(total)
                },
                scaleLabel: {
                    display: true,
                    labelString: "Cantidad"
                }
            }],
            xAxes: [{
                ticks: {
                    autoSkip: false
                }
            }]
        }
    }

});
}


function construirGraficoVentasXProducto(ventasXProductos) {
    var arrayValoresVentas = new Array();
    var arrayLabelProductos = new Array();
    var i = 0;
    var total = 0;
    ventasXProductos.forEach(function(ventaXProducto) {
        if(i < 10){ //top 10 de productos
            arrayValoresVentas.push(ventaXProducto.Total);
            arrayLabelProductos.push(ventaXProducto.Nombre);
        }else{
            total = total + ventaXProducto.Total;
        }
        i++;
    });
    if(total > 0){
        arrayValoresVentas.push(total);
        arrayLabelProductos.push('otros productos');
    }

    var ctx = document.getElementById("ventasXProducto");
    var data = {
        labels: arrayLabelProductos,
        datasets: [
            {
                data: arrayValoresVentas,
                backgroundColor: arrayColores,
                hoverBackgroundColor: arrayColores
            }]
    }
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options:{
            title:{
                display: true,
                text: 'Top 10 de productos más vendidos'
            }
        }
    });
}
